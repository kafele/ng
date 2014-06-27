var initializeContent = function()
{

	/** 
	 * Updates the mainPanel toolbox
	 *
	 * @param	string		Name of the toolbox view to load.
	 *						Must be located in the themes/admin/views folder
	 * @param	function	Function to execute when the toolbox is loaded.
	 *	
	 */
	MUI.initToolbox = function(toolbox_url, onContentLoaded)
	{

		// Creates the header toolbox if it doesn't exists
		if ( ! $('mainPanel_headerToolbox')) {
			this.panelHeaderToolboxEl = new Element('div', {
				'id': 'mainPanel_headerToolbox',
				'class': 'panel-header-toolbox'
			}).inject($('mainPanel_header'));
		}
	
		if (toolbox_url)
		{
			cb = '';
			if (onContentLoaded)
			{
				cb = onContentLoaded;
			}
		
			MUI.updateContent({
				'element': $('mainPanel'),
				'childElement': $('mainPanel_headerToolbox'),
				'loadMethod': 'xhr',
				'url': base_url + 'admin/core/get/toolboxes/' + toolbox_url
				// 'onContentLoaded': onContentLoaded
			});
		}
		else
		{
			$('mainPanel_headerToolbox').empty();
		}
	
	};
	
	
	/** 
	 * Init a module toolbox
	 * @param	string 	module name
	 * @param	toolbox_url for this module
	 *	
	 */
	MUI.initModuleToolbox = function(module, toolbox_url)
	{

		// Creates the header toolbox if it doesn't exists
		if ( ! $('mainPanel_headerToolbox')) {
			this.panelHeaderToolboxEl = new Element('div', {
				'id': 'mainPanel_headerToolbox',
				'class': 'panel-header-toolbox'
			}).inject($('mainPanel_header'));
		}
	
		if (toolbox_url)
		{
			MUI.updateContent({
				'element': $('mainPanel'),
				'childElement': $('mainPanel_headerToolbox'),
				'loadMethod': 'xhr',
				'url': base_url + 'admin/module/' + module + '/' +  module + '/get/admin/toolboxes/' + toolbox_url
			});
		}
		else
		{
			$('mainPanel_headerToolbox').empty();
		}
	
	};	



	/** 
	 * Creates Accordion
	 * @param	string 	HTMLElement ID
	 *	
	 */
	MUI.initAccordion = function(togglers, elements) 
	{	
//		if ($(el))
//		{
		//	var col = $$('#' + el + ' h3.toggler');
			var acc = new Fx.Accordion(togglers, elements, {
				display: 0,
				opacity: false,
				alwaysHide: true,
				initialDisplayFx: false,
				onActive: function(toggler, element){
					toggler.addClass('expand');
				},
				onBackground: function(toggler, element){
					toggler.removeClass('expand');
				}
			});
//		}
	};

	
	/**
	 * Adds effect to sideColumn
	 *
	 */
	MUI.initSideColumn = function()
	{
		// element to slide & linked button
		var maincolumn = $('maincolumn');
		var element = $('sidecolumn');		
		var button = $('sidecolumnSwitcher');
		
		// button event
		button.addEvent('click', function(e)
		{
			var e = new Event(e).stop();
			
			if (this.retrieve('status') == 'close')
			{
				element.removeClass('close');
				maincolumn.addClass('with-side');

				this.set('value', Lang.get('ionize_label_hide_options'));
				this.store('status', 'open');

				Cookie.write('sidecolumn', 'open');
				
			}
			else
			{
				element.addClass('close');
				maincolumn.removeClass('with-side');
				
				this.set('value', Lang.get('ionize_label_show_options'));
				this.store('status', 'close');
				Cookie.write('sidecolumn', 'close');
			}
			
		});
		
		/*
		 * Get the cookie stored option state and apply
		 */
		var pos = Cookie.read('sidecolumn');

		if (pos != null && pos == 'close')
		{
			// element.hide();
			element.addClass('close');
			maincolumn.removeClass('with-side');
			
			button.set('value', Lang.get('ionize_label_show_options'));
			button.store('status', 'close');
		}
		else
		{
			element.removeClass('close');
			maincolumn.addClass('with-side');

			button.store('status', 'open');
			button.set('value', Lang.get('ionize_label_hide_options'));
		}
	};

	
	/**
	 * Updates multiple elements
	 *
	 * @param	array	Array of elements to update. Array('element_id' => 'url_to_call')
	 *
	 */
	MUI.updateElements = function (elements)
	{
		$each(elements, function(options, key)
		{
			MUI.updateElement(options);
		});
	};


	/**
	 * Updates one element
	 *
	 * @param	string Element ID
	 * @param	Object Core.updateContent options object
	 *
	 */
	MUI.updateElement = function (options)
	{
		// Cleans URLs
		options.url = base_url + MUI.cleanUrl(options.url);
			
		// If the panel doesn't exists, try to update directly one DomHTMLElement
		if ( ! MUI.Windows.instances.get(options.element) && ! MUI.Panels.instances.get(options.element))
		{
			new Request.HTML({
				'url': options.url,
				'update': $(options.element)
			}).send()
		}
		else
		{
			// Update options.element to be the DOM object
			options.element = $(options.element);
			
			// Update the Mocha UI panel with Core.updateContent() method
			MUI.updateContent(options);
		}
	};

	
	/**
	 * Cleans the base URL
	 *
	 * @return string	URL without the first part
	 *
	 */
	MUI.cleanUrl = function(url)
	{
		// Cleans URLs
		url = url.replace(base_url, '');
		
		// Base URL contains the lang code. Try to clean without the lang code
		url = url.replace(base_url.replace(Lang.get('current') + '/', ''), '');
		
		return url;
	};

	
	/**
	 * Displays one CSS "help link" on each label which have a title
	 *
	 */
	MUI.initLabelHelpLinks = function(element)
	{
		if (show_help_tips == '1')
		{
			$$(element + ' label').each(function(el, id)
			{
				if (el.getProperty('title'))
				{
					el.addClass('help');
				}
			});
			
			new Tips(element + ' .help', {'className' : 'tooltip'});
		}
	};
	
	
	MUI.onContentLoaded = function()
	{
		// alert('loaded');
	};


	MUI.myChain.callChain();
}
