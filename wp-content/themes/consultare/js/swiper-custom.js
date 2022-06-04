var mainSlider = new Swiper ( '#slider-section', {
	autoHeight: true, //enable auto height
	effect: 'slide',
	speed: 300,
	// If we need pagination
	pagination: {
		el: '#slider-section .swiper-pagination',
		type: 'bullets',
		clickable: 'true',
	},

	// Navigation arrows
	navigation: {
		nextEl: '#slider-section .swiper-button-next',
		prevEl: '#slider-section .swiper-button-prev',
	},
});
