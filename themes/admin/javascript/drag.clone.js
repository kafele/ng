/**
 * Drag.Clone
 * Mootools 1.2.4 Addon
 * Creates a clone from one element and make it draggable
 *
 * Author : Partikule Studio
 * Since:	Ionize 0.9.5
 *
 * Needs : 	
 *  Drag
 *	Drag.Move
 *
 * Arguments:
 *  1. el - (element) The Element to apply the drag to.
 *  2. options - (object, optional) The options object. See below.
 *
 * Options:
 *  All the base Drag.Move options, plus:
 *  - handle : (string: defaults to false) A selector to select an element inside the element to be used as the handle for dragging that element.If no match is found, the element is used as its own handle.
 *
 * Usage : 
 *
 *		var myDrag = new Drag.Clone('draggable', {
 *			
 *			droppables: '.droppable',
 *			
 *			handle: '.drag',
 *			
 *			onDrop: function(element, droppable, event)
 *			{
 *				if (!droppable) console.log(element, ' dropped on nothing');
 *				else console.log(element, 'dropped on', droppable, 'event', event);
 *			},
 *			
 *			onEnter: function(el, droppable)
 *			{
 *				droppable.tween('background-color','#98B5C1');
 *				console.log('enter droppable');
 *			},
 *			
 *			onLeave: function(el, droppable)
 *			{
 *				droppable.tween('background-color','#fff');
 *				console.log('leave droppable');
 *			}
 *		});
 *
 *
 */

Drag.Clone = new Class({
	
	Implements: [Events, Options],
	
	options: {
		droppables: [],
		snap: 4,
		opacity: 1,
		revert: false,
		handle: false,
		precalculate: true
	},
	
	initialize: function(element, options)
	{
		this.setOptions(options);
		this.idle = true;
		
		if (this.options.revert) this.effect = new Fx.Morph(null, $merge({duration: 250, link: 'cancel'}, this.options.revert));
		
		(this.options.handle ? element.getElement(this.options.handle) || element : element).addEvent('mousedown', this.start.bindWithEvent(this, element));
	},

	start: function(event, element)
	{
		if (!this.idle) return;
		this.idle = false;
		this.element = element;
		this.opacity = element.get('opacity');
		this.clone = this.getClone(event, element);

		this.drag = new Drag.Move(this.clone, {
			snap: this.options.snap,
			droppables: this.options.droppables,
			onSnap: function(){
				event.stop();
				this.clone.setStyle('visibility', 'visible');
				this.clone.set('opacity', this.options.opacity || 0);
				this.snapped.bind(this);
			}.bind(this),
			onDrop: this.dropped.bind(this),
			onEnter: this.entered.bind(this),
			onLeave: this.leaved.bind(this),
			onCancel: this.reset.bind(this),
			onComplete: this.end.bind(this)
		});

		this.drag.start(event);
	},


	end: function()
	{
		this.drag.detach();
		if (this.effect){
			var dim = this.element.getStyles('width', 'height');
			var pos = this.clone.computePosition(this.element.getPosition(this.clone.offsetParent));
			this.effect.element = this.clone;
			this.effect.start({
				top: pos.top,
				left: pos.left,
				width: dim.width,
				height: dim.height,
				opacity: 0.25
			}).chain(this.reset.bind(this));
		} else {
			this.reset();
		}
	},

	reset: function()
	{
		this.idle = true;
		this.clone.destroy();
		this.fireEvent('complete', this.element);
	},

	dropped: function(element, droppable, event) { this.fireEvent('drop', [element, droppable, event]); },
	snapped: function(event, element) {	this.fireEvent('snap', element); },
	entered: function(element, droppable) { this.fireEvent('enter', [element, droppable]); },
	leaved: function(element, droppable) { this.fireEvent('leave', [element, droppable]); },

	getClone: function(event, element)
	{
		if ($type(this.options.clone) == 'function') return this.options.clone.call(this, event, element);

		var dim = element.getSize();

		var clone = element.clone().setStyles({
			'position': 'absolute',
			'top': element.getCoordinates()['top'],
			'left': element.getCoordinates()['left'],
			'visibility': 'hidden',
			'width': dim.x + 'px',
			'height': dim.y + 'px',
			'display': 'block',
			'z-index': 10000
		});
		//prevent the duplicated radio inputs from unchecking the real one
		if (clone.get('html').test('radio')) {
			clone.getElements('input[type=radio]').each(function(input, i) {
				input.set('name', 'clone_' + i);
			});
		}
		return clone.inject(document.body);
	}

});

Element.implement({
	makeCloneDraggable: function(options) {
		return new Drag.Clone(this, options);
	}
});