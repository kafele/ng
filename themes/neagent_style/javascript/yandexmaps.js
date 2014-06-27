var map, geoResult, container;
// Функция для отображения результата геокодирования
// Параметр value - адрес объекта для поиска
function showAddress (value) {
	if (!value)
		value = address;
	if (!value)
		return false;
	// Удаление предыдущего результата поиска
	map.removeOverlay(geoResult);
	
	// Запуск процесса геокодирования
	var geocoder = new YMaps.Geocoder(value, {results: 1, boundedBy: map.getBounds()});
	
	// Создание обработчика для успешного завершения геокодирования
	YMaps.Events.observe(geocoder, geocoder.Events.Load, function () {
		// Если объект был найден, то добавляем его на карту
		// и центрируем карту по области обзора найденного объекта
		map.redraw();
		if (this.length()) {
			geoResult = this.get(0);
			map.addOverlay(geoResult);
			map.setBounds(geoResult.getBounds());
		}else {
			//alert("Ничего не найдено")
		}
	});

	// Процесс геокодирования завершен неудачно
	YMaps.Events.observe(geocoder, geocoder.Events.Fault, function (geocoder, error) {
		//alert("Произошла ошибка: " + error);
	})
}

// Создание обработчика для события window.onLoad
YMaps.jQuery(function () {
	// Создание экземпляра карты и его привязка к созданному контейнеру
	container = YMaps.jQuery("#extend-3"),
    map = new YMaps.Map(container[0]);
	map.addControl(new YMaps.SmallZoom());
	map.addControl(new YMaps.ToolBar());
	map.addControl(new YMaps.TypeControl());
	//отображение нужного адреса
	showAddress();
});