var globalFlag = 0;
var globalFlag_directory = 0;
(function($, Drupal, window, document) {
    var aux = 0;
    'use strict';


    Drupal.behaviors.infiniteScrollAddClass = {
        attach: function(context, settings) {
            $('.button').click(function() {

            });
            $('.view-vista-facultad-productos-academicos .masonry-layout').masonry('reloadItems');
            $('.view-vista-facultad-productos-academicos .masonry-layout').masonry('layout');
        }
    };

    // To understand behaviors, see https://drupal.org/node/756722#behaviors
    Drupal.behaviors.uBosque = {
        attach: function(context, settings) {
            var tabletSize = 788;
            var wowAnimation = 'fadeInUp';
            var htmlBtnClose = '<div class="close-cerrar"><div class="close-inner"><span class="a">&nbsp;</span><span class="b">&nbsp;</span></div></div>';


            ///////////////////////////////////////////////////////////////////////////
            // START: CENTRO INFORMACIÃ“N - EVENTOS
            // URL: /centro-informacion/eventos
            ///////////////////////////////////////////////////////////////////////////
            $('.calendar-calendar tr:nth-of-type(2) td .month')
                .filter(function() {
                    return $.trim($(this).text()) === '1';
                })
                .parent()
                .prevAll()
                .addClass('js-added-class-previous-month');

            $('.calendar-calendar tr:last-child td .month')
                .filter(function() {
                    return $.trim($(this).text()) === '1';
                })
                .parent()
                .addClass('js-added-class-next-month')
                .nextAll()
                .addClass('js-added-class-next-month');

            //// END: CENTRO INFORMACIÃ“N - EVENTOS

            ///////////////////////////////////////////////////////////////////////////
            // START: CENTRO INFORMACIÃ“N - NOTICIAS
            // URL: /centro-informacion/noticias
            ///////////////////////////////////////////////////////////////////////////
            $('.block-views-blocknoticias-1-block-4 .text-content').matchHeight();

            jQuery('.academic-program-custom-search .form-select').addClass('element-hidden');
            jQuery('.academic-program-custom-search .form-submit').addClass('element-hidden');
            jQuery('.academic-program-custom-search .js-form-item-label').addClass('element-hidden');
            jQuery('.academic-program-custom-search .js-form-item-nodes-titles').addClass('element-hidden');

            /*
		var wow = new WOW(
		  {
		    boxClass:     'wow-section',      // animated element css class (default is wow)
		    animateClass: 'animated', // animation css class (default is animated)
		    offset:       0,          // distance to the element when triggering the animation (default is 0)
		    mobile:       true,       // trigger animations on mobile devices (default is true)
		    live:         true,       // act on asynchronously loaded content (default is true)
		    callback:     function(box) {
		      // the callback is fired every time an animation is started
		      // the argument that is passed in is the DOM node being animated
		    },
		    scrollContainer: null // optional scroll container selector, otherwise use window
		  }
		);

		$('.wow-section').addClass(wowAnimation);*/
            //wow.init();

            // Cambio de idioma del modulo Gtranslate.
            jQuery('.gtranslate select > option[value=""]').text("Seleccione un Lenguaje");
            jQuery('.gtranslate select > option[value="es|es"]').text("EspaÃ±ol");
            jQuery('.gtranslate select > option[value="es|sq"]').text("AlbanÃ©s");
            jQuery('.gtranslate select > option[value="es|ar"]').text("ArÃ¡bica");
            jQuery('.gtranslate select > option[value="es|bg"]').text("BÃºlgaro");
            jQuery('.gtranslate select > option[value="es|ca"]').text("CatalÃ¡n");
            jQuery('.gtranslate select > option[value="es|zh-CN"]').text("Chino (Simplificado)");
            jQuery('.gtranslate select > option[value="es|zh-TW"]').text("chino (Tradicional)");
            jQuery('.gtranslate select > option[value="es|hr"]').text("Croata");
            jQuery('.gtranslate select > option[value="es|en"]').text("Ingles");
            jQuery('.gtranslate select > option[value="es|tl"]').text("Filipino");
            jQuery('.gtranslate select > option[value="es|fr"]').text("FrancÃ©s");
            jQuery('.gtranslate select > option[value="es|gl"]').text("Gallego");
            jQuery('.gtranslate select > option[value="es|de"]').text("AlemÃ¡n");
            jQuery('.gtranslate select > option[value="es|el"]').text("Griego");
            jQuery('.gtranslate select > option[value="es|it"]').text("Italiano");
            jQuery('.gtranslate select > option[value="es|ja"]').text("JaponÃ©s");
            jQuery('.gtranslate select > option[value="es|ko"]').text("Coreano");
            jQuery('.gtranslate select > option[value="es|no"]').text("Noruego");
            jQuery('.gtranslate select > option[value="es|pl"]').text("Polaco");
            jQuery('.gtranslate select > option[value="es|pt"]').text("PortuguÃ©s");
            jQuery('.gtranslate select > option[value="es|ru"]').text("Ruso");
            jQuery('.gtranslate select > option[value="es|sv"]').text("Sueco");





            // http://ubosque.d8.seedlabs.co/admisiones/pregrado
            // http://ubosque.d8.seedlabs.co/admisiones/posgrado
            makeWow('.bloques-verticales .block, .block-block-contentcc2e02ee-d8a2-496f-a6ba-bb4c26c7a9aa, .acordeon-fechas, .fechas-posgrado');

            // http://ubosque.d8.seedlabs.co/becas-estimulos
            makeWow('.block-block-content2aabbd2c-b6c8-4dc0-9e67-08f73e1bbbaf h2');
            makeWow('.block-block-content65b32e82-08d8-4c45-97b6-872038e7e273 h2');
            makeWow('.block-block-content4477572d-a5f5-4ad3-a0c6-6adaa24c025e h2');
            makeWow('.block-block-contenta3273077-c6c0-4554-9286-f7a9a890b6e2');
            makeWow('.field--name-field-bea > .field__item');
            externalLinks();

            startMasonry('.view-vista-facultad-productos-academicos .views-infinite-scroll-content-wrapper', '.views-row');

            function startMasonry(element, viewsRow) {
                var $container = $(element);

                $container.imagesLoaded(function() {
                    $container.masonry({
                        itemSelector: viewsRow,
                        percentPosition: true,
                        alignLTR: true
                            //originLeft: "isOriginLeft",
                            //gutter: 15
                    }).resize();
                });

                // makeMasonryWorkWithInfiniteScroll
                $container.masonry('reloadItems');
                $container.masonry('layout').resize();
            }

            if ($('.page-centro-informacion .centro-informacion-relatos').length) {
                startMasonry('#block-views-block-centro-de-informacion-block-7 .view-content', '.views-row');
            }


			// HACK en relatos, inserta el block_1 dentro del block_2 antes que se ejecute el masonry
			// url: /centro-informacion/relatos
			$('.page-masonry .view-id-relatos.view-display-id-block_1 .views-row')
			.prependTo('.view-id-relatos.view-display-id-block_2 .views-infinite-scroll-content-wrapper');


            // REVISAR
            // url: /centro-informacion/bosque-medios
            // url: /centro-informacion/noticias
			// url: /centro-informacion/relatos
            var $containerNoti = $('.page-masonry .view .views-infinite-scroll-content-wrapper');

            $containerNoti.imagesLoaded(function() {
                $containerNoti.masonry({
                    itemSelector: '.views-row',
                    percentPosition: true,
                    alignLTR: false,
                    columnWidth: $('.view-content').find('.views-row')[1]
                        //originLeft: "isOriginLeft",
                        //gutter: 15
                }).resize();
            });

            // makeMasonryWorkWithInfiniteScroll
            $containerNoti.masonry('reloadItems');
            $containerNoti.masonry('layout').resize();
            // END: REVISAR

            // Test1
            //$('<div class="field field--name-field-image field--type-image field--label-hidden field__items"><div class="field__item"><img alt="Relato de prueba" src="/sites/default/files/2017-03/ImgBanner_2.jpg" typeof="foaf:Image" height="501" width="1201"></div></div>').prependTo('.centro-informacion-relatos .node')


            // URL: /centro-informacion/noticias
            $('.view-noticias-1 .form-actions').insertBefore('.form-item-field-noticias-taxonomia-target-id');
            $('<label class="js-append">Consultar: </label>').appendTo('.view-noticias-1 .form-actions');
            $('#edit-submit-noticias-1').val('TODAS');
            // formTextValue();

            $('.content-sub-menu > .block-inner > .block').matchHeight({
                byRow: true,
                property: 'height'
            });

            // START: CENTRO INFORMACION - EL BOSQUE RESPONDE
            // URL: /centro-informacion/bosque-responde

            $('.view-videos.view-display-id-block_1 .views-row').matchHeight({
                byRow: true,
                property: 'height'
            });

            // URL: /inscripciones/
            if ($('.continua-admisiones').length) {
                $('.continua-admisiones > .block-inner > .block').matchHeight({
                    byRow: true,
                    property: 'height'
                });
            }

            // URL: /inscripciones/
            if ($('.agrupacion-inscripciones').length) {
                $('.agrupacion-inscripciones h2').addClass('js-field field');
                var bloques = $('.agrupacion-inscripciones > .block-inner > .block > .block-inner');
                bloques.each(function() {
                    $(this).find('.field:lt(2)').wrapAll('<div class="js-wrapper">');
                });

                $('.agrupacion-inscripciones .js-wrapper').matchHeight({
                    byRow: true,
                    property: 'height'
                });
            }
			
			// 	URL: /preguntas-frecuentes/facultades/4
			if ($('.page-preguntas-frecuentes').length) {
				var
				pageTitle = $('.view-id-repo_preguntas_frecuentes .view-header h2').text().toLowerCase();

				// Agregamos la clase al elemento de la vista que tenga mismo texto que el page title
				$('.view-id-menu_preguntas_frecuentes.view-display-id-block_1 a').filter(function() {
					return $(this).text().toLowerCase() === pageTitle;
				})
				.parents('.views-row')
				.addClass('menu-item--active-trail');
				
				// Este es para prevenir que el primer hijo de la vista adquiera estilos de primer hijo
				$('<div class="views-row appended-js" style="border-bottom: 0 !important" />')
				.prependTo('.view-id-menu_preguntas_frecuentes.view-display-id-block_1 .view-content');
			}
			
			

            if ($('.page-faculties').length) {
                $('.product-basic-feature-content-large, .product-basic-feature-content, .product-full-feature-content').matchHeight({
                    byRow: true,
                    property: 'height'
                });
            }

            $('.bloques-verticales > .block-inner .block-inner').matchHeight({
                byRow: true,
                property: 'height'
            });

            /*
            $('#webform-submission-formulario-recibir-mas-informaci-form input').each(function() {
            	$(this).removeAttr('placeholder');
            	$(this).prev().removeClass('visually-hidden').wrapInner('<span />');
            	$(this).insertBefore($(this).prev());
            });
            */

            // Admisiones
            // $('.block-block-groupd558f438-0308-4e4f-ba4c-22a9df6674f7').remove();

            function getQuery(variable) {
                var query = window.location.search.substring(1);
                var vars = query.split("&");
                for (var i = 0; i < vars.length; i++) {
                    var pair = vars[i].split("=");
                    if (pair[0] == variable) {
                        return pair[1];
                    }
                }
                return false;
            }
            var title = getQuery('title');
            $('.path-parent-centro-informacion .calendar-calendar .month.mini-day-on a').each(function() {
                var href = $(this).attr('href');
                var res = href.split("/");
                var hola = res[3];
                var year = hola.substring(0, 4);
                var month = hola.substring(4, 6);
                var day = parseInt(hola.substring(6, 8));
                var day_cont = day + 1;
                if (title) {
                    $(this).attr('href', '/centro-informacion/eventos/busqueda?title=' + title + '&field_fecha_fin2_value[min]=' + day + '-' + month + '-' + year + ' 00:00:00&field_fecha_fin2_value[max]=' + day + '-' + month + '-' + year + ' 23:59:59');
                } else {
                    $(this).attr('href', '/centro-informacion/eventos/busqueda?field_fecha_fin2_value[min]=' + day + '-' + month + '-' + year + ' 00:00:00&field_fecha_fin2_value[max]=' + day + '-' + month + '-' + year + ' 23:59:59');
                }
            });


			// URL: /centro-informacion/eventos
			if ($('.centro-informacion-eventos').length) {
				addFilterButton();
			}
		
			// URL: /el-bosque-te-acoge/filter?tipo_de_casa=All&valor_arriendo_value=All&estancia=All
			if ($('.page-filtro-el-bosque-te-acoge').length) {
				addFilterButton();
			}

			function addFilterButton() {
				var filtros = '<a class="btn-filtro toggle-filtro">Filtros</a>';
			
				if ($('#main .pager__item').length) {
					$(filtros).appendTo('#main .pager__item');
				} else {
					$('<div class="filtro-wrapper" />').insertAfter('#main .view-content');
					$(filtros).appendTo('#main .filtro-wrapper');
				}

				$('<ul class="js-append-filtro"><li class="pager__item">' + filtros + '</li></ul>').insertAfter('#main .pager');
			
				$('body').addClass('filtro-is-present');
				$(document).on('click', '.toggle-filtro', function() {
					$('body').toggleClass('filtro-is-open');
				});
			
				$('.sidebar-first').wrapInner('<div class="js-decidete-inner" />');
				$(htmlBtnClose + '<h2 class="title-filtros js-append">Filtros</h2>').prependTo('.sidebar_first');
				$('<div class="js-sidebar-button"><a>Limpiar Filtros</a></div>').appendTo('.sidebar-first');
			
				$(document).on('click', '.sidebar-first .close-cerrar', function() {
					$('body').removeClass('filtro-is-open');
				});
			}


            $(document).ready(function() {

                $(context).find('body').once('documentReady').each(function() {

                    var d = new Date();

                    var meses = new Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
                    var diasSemana = new Array("Domingo", "Lunes", "Martes", "MiÃ©rcoles", "Jueves", "Viernes", "SÃ¡bado");
                    jQuery('.centro-informacion-eventos .events-title-header .events-day').text(diasSemana[d.getDay()]);
                    jQuery('.centro-informacion-eventos .events-title-header .events-dd').text(d.getDate());
                    jQuery('.centro-informacion-eventos .events-title-header .events-month').text("de " + meses[d.getMonth()]);

                    var getUrlParameter = function getUrlParameter(sParam) {
                        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
                            sURLVariables = sPageURL.split('&'),
                            sParameterName,
                            i;

                        for (i = 0; i < sURLVariables.length; i++) {
                            sParameterName = sURLVariables[i].split('=');

                            if (sParameterName[0] === sParam) {
                                return sParameterName[1] === undefined ? true : sParameterName[1];
                            }
                        }
                    };

                    var fMin = getUrlParameter('field_inicio_2_value');
                    var fMax = getUrlParameter('field_fecha_fin2_value');
                    if (typeof fMin !== 'undefined' && typeof fMax !== 'undefined') {
                        var vector = fMin.split('-');
                        var fechaU = vector[2] + "/" + vector[0] + "/" + vector[1]; //Standard format for all browsers
                        var dt = new Date(fechaU);
                        jQuery('.centro-informacion-eventos .events-title-header .events-day').text(diasSemana[dt.getDay()]);
                        jQuery('.centro-informacion-eventos .events-title-header .events-dd').text(dt.getDate());
                        jQuery('.centro-informacion-eventos .events-title-header .events-month').text("de " + meses[dt.getMonth()]);
                    }

                    // Filtro medios bosque
                    var n = d.getFullYear();
                    var fechas = "";
                    for (var i = 2015; i <= n; i++) {
                        fechas += '<option value="' + i + '">' + i + '</option>';
                    }
                    //se aÃ±aden todos los elementos en un div para facilitar estilizaciÃ³n
                    jQuery('.page-node-type-bosque-en-los-medios.path-parent-centro-informacion #main').prepend('<div class="filters-container"></div>');
                    jQuery('.page-node-type-bosque-en-los-medios.path-parent-centro-informacion .filters-container').prepend('<div class="buscar"></div>');
                    jQuery('.page-node-type-bosque-en-los-medios.path-parent-centro-informacion .filters-container').prepend('<div class="difusion"></div>');
                    jQuery('.page-node-type-bosque-en-los-medios.path-parent-centro-informacion .filters-container').prepend('<div class="anno"></div>');
                    jQuery('.page-node-type-bosque-en-los-medios.path-parent-centro-informacion .filters-container').prepend('<div class="consultar"></div>');
                    jQuery('.page-node-type-bosque-en-los-medios.path-parent-centro-informacion .filters-container .buscar').prepend('<input type="submit" value="BUSCAR" class="button js-form-submit form-submit">');
                    jQuery('.page-node-type-bosque-en-los-medios.path-parent-centro-informacion .view-bosque-en-los-medios .form-select').clone().prependTo('.page-node-type-bosque-en-los-medios.path-parent-centro-informacion .filters-container .difusion');
                    jQuery('.page-node-type-bosque-en-los-medios.path-parent-centro-informacion .filters-container .difusion').prepend('<div class="label-filtro"><label>Medio de DifusiÃ³n:</label></div>');
                    jQuery('.page-node-type-bosque-en-los-medios.path-parent-centro-informacion .filters-container .anno').prepend('<select id="filtro-ano" class="filtro-bosque-medios" name="ano">' + fechas + '</select>');
                    jQuery('.page-node-type-bosque-en-los-medios.path-parent-centro-informacion .filters-container .anno').prepend('<div class="label-filtro"><label>AÃ±o:</label></div>');
                    jQuery('.page-node-type-bosque-en-los-medios.path-parent-centro-informacion .filters-container .consultar').prepend('<div class="bosque-medios-all"><a href="/centro-informacion/bosque-medios">Todas</a></div>');
                    jQuery('.page-node-type-bosque-en-los-medios.path-parent-centro-informacion .filters-container .consultar').prepend('<div class="label-filtro"><label>Consultar:</label></div>');
                    jQuery('.page-node-type-bosque-en-los-medios.path-parent-centro-informacion .bosque-medios-title').clone().prependTo('.page-node-type-bosque-en-los-medios.path-parent-centro-informacion .filters-container');

                    jQuery('.page-node-type-bosque-en-los-medios.path-parent-centro-informacion .filters-container .anno select').val(n);

                    var titleBosqueMedios = jQuery('.page-node-type-bosque-en-los-medios.path-parent-centro-informacion .bosque-medios-title .block-inner h2').html();
                    jQuery('.page-node-type-bosque-en-los-medios.path-parent-centro-informacion .filters-container .bosque-medios-title .block-inner').prepend('<h1>' + titleBosqueMedios + '</h1>');

                    jQuery('.page-node-type-bosque-en-los-medios.path-parent-centro-informacion .filters-container .form-select').on('change', function() {
                        var value = $(this).val();
                        jQuery('.page-node-type-bosque-en-los-medios.path-parent-centro-informacion .view-bosque-en-los-medios .form-select option[value=' + value + ']').prop('selected', true);
                    });

                    jQuery('.page-node-type-bosque-en-los-medios.path-parent-centro-informacion .filters-container .form-submit').on('click', function() {
                        jQuery('.page-node-type-bosque-en-los-medios.path-parent-centro-informacion .view-bosque-en-los-medios .js-form-submit').click();
                    });

                    $('#filtro-ano').on('change', function() {
                        var value = $(this).val();
                        var ano_inicio = '01-01-' + value;
                        var ano_fin = '31-12-' + value;
                        jQuery('.form-item-field-fecha-publicacion-value-max .form-text').val(ano_fin).css('display', 'none');
                        jQuery('.form-item-field-fecha-publicacion-value-min .form-text').val(ano_inicio).css('display', 'none');
                    });
                    //fin Filtro medios bosque

                    // Borrar esta lÃ­nea
                    $('<div class="submenu-mainmenu borrar-submenu-mainmenu"></div>').insertAfter('.submenu-mainmenu-2');

                    // Ejecutamos el script del menÃº principal solo en versiÃ³n desktop


                    /*
                    $('.content-sub-menu').each(function() {
                    	$(this).find('.block').matchHeight({
                    		byRow: true,
                    		property: 'height'
                    	});
                    });*/

                    mainMenuHomeMobile();

                    function mainMenuHomeMobile() {
                        submenuMainMenu();
                        $('.menu--menu-principal .menu-wrapper > .menu').addClass('first-ul');
                        $('.menu--menu-principal .menu-wrapper > .menu > .menu-item').addClass('first-li');
                        $('.menu--menu-principal .menu-wrapper > .menu > .menu-item > a').addClass('first-a');
                        $('.first-ul > .menu-item > .menu').addClass('second-ul');
                        $('.first-ul > .menu-item > .menu > .menu-item').addClass('second-li');
                        $('.first-ul > .menu-item > .menu > .menu-item > a').addClass('second-a');
                        $('.second-ul > .menu-item > .menu').addClass('third-ul');
                        $('.second-ul > .menu-item > .menu > .menu-item').addClass('third-li');
                        $('.second-ul > .menu-item > .menu > .menu-item > a').addClass('third-a');



                        //desplegableMaker(wrapper, parent, tabContent, title)
                        desplegableMaker('.menu--menu-principal', '.first-li', '.second-ul', '.first-a', 'desplegable-open-1', false);
                        //desplegableMaker('.menu--menu-principal', '.second-li', '.third-ul', '.second-a', 'desplegable-open-2', false);


                        $('<span class="arrow-toggle"><span></span></span>').appendTo('.second-li > a');

                        // haciendo que el botÃ³n de idioma (mobile) abra el bloque de idomas Google
                        var btnIdi = '.menu-twig-impreso .btn-idi';
                        $('.block-gtranslate').clone().insertAfter(btnIdi).addClass('second-ul');
                        $(document).on('click', btnIdi, function() {

                        });

                        $('.menu--menu-principal a').each(function() {
                            var context = $(this);
                            if (!context.next().length) {
                                context.find('.arrow-toggle').remove();
                            }
                            /* else {
						context.clone().prependTo(context.next()).wrap('<li class="menu-item" />').find('.arrow-toggle').remove();
					}*/
                        });

                        $(document).on('click', '.menu--menu-principal .arrow-toggle', function(e) {
                            e.preventDefault();
                        });
                    }

                    searchHeaderMobile();

                    function searchHeaderMobile() {
                        var btn = $('.buscar-mobile'),
                            btnClose = $('.overlay-top a');
                        btn.removeAttr('href');

                        btn.click(function() {
                            $('body').toggleClass('header-search-opened');
                        });

                        btnClose.click(function() {
                            $('body').removeClass('header-search-opened');
                        });
                    }

                    callMenuLateral('.hamburger-button', 'main-menu-open');
                    callMenuLateral('.lateral-button', 'lateral-menu-open');

                    homeNewsHeight();
                    // Hace que tengan la misma altura los bloques de QuÃ© estÃ¡ pasando
                    function homeNewsHeight() {
                        $('.block-views-blocknoticias-1-block-1 .view-content .views-row .text-content-inner').matchHeight({
                            byRow: true,
                            property: 'height'
                        });
                    }


                    if ($(window).width() > tabletSize) {
                        menuFaculty();

                    }

                    function menuFaculty() {
                        /*
                        $('.menu--menu-superior-home-derecho .menu-item:eq(0)').hover(
                        	function() {
                        		$('.menu-faculty').slideDown();
                        		$('body').addClass('sub-menu-active');
                        	},
                        	function() {
                        		$('.menu-faculty').slideUp();
                        		$('body').removeClass('sub-menu-active');
                        	}
                        );
                        $('.menu--menu-superior-home-derecho .menu-item:eq(3)').hover(
                        	function() {
                        		$('.menu-translation').slideDown();
                        		$('body').addClass('sub-menu-active');
                        	},
                        	function() {
                        		$('.menu-translation').slideUp();
                        		$('body').removeClass('sub-menu-active');
                        	}
                        );
                        */
                    }



                    if ($('.alma-matter').length) {
                        $('.alma-matter .file--application-pdf a').text('Ver documento');
                    }

                    if ($('.path-frontpage').length) {
                        // tabMaker(@wrapper, @tabContent, @tabTitle, @espacioOpcional)
                        tabMaker('.tabs-home', '.block', 'h3', '15px');
                        addPlaceholder('.banner-search .search-block-form .form-text', 'Ej.: Programa de DiseÃ±o y ComunicaciÃ³n');
                        monthsHover();
                    }

                    // URL: /centro-informacion/
                    if ($('.page-centro-informacion').length) {
                        monthsHover();
                    }

                    // URL: /facultad/creacion-comunicacion/
                    if ($('.view-eventos-facultad').length) {
                        monthsHover();
                    }

                    // URL: /electivas-institucionales
                    if ($('.tabs-horizontales-1').length) {
                        tabMaker('.tabs-horizontales-1', '.block', 'h2', '15px');
                        $('<div class="js-field-label soy-un-append">Competencias</div>').prependTo('.tabs-horizontales-1 .field--name-field-body-2');
                    }

                    // URL: /electivas-institucionales
                    if ($('.acordeon-electiva').length) {

                        // desplegableMaker(wrapper, parent, tabContent, title, activeClass, openFirst);

                        desplegableMaker('.acordeon-electiva', '.field--name-field-electiva-parrafo > .field__item', '.bar-desplegable-content', '.bar-desplegable-button', 'desplegable-open', false, 1);


                        $('<div class="js-append-mobile" />').prependTo('.bar-desplegable-content');
                        $('.field--name-field-creditos-programa, .field--name-field-duraci, .field--name-field-modalidad').each(function() {
                            $(this).clone().addClass('cloned').prependTo($(this).parent().next().find('.js-append-mobile'));
                        });

                    }

                    //URL: /internacionalizacion/becas-internacionales
                    if ($('.acordeon-becas-inter').length) {
                        desplegableMaker('.acordeon-becas-inter', '.views-infinite-scroll-content-wrapper > .views-row', '.bar-desplegable-content', '.bar-desplegable-button', 'desplegable-open', false, 1);
                    }

                    //ACORDEON con vistas
                    if ($('.tabs-acordeon-views').length) {
                        desplegableMaker('.tabs-acordeon-views', '.views-row', '.bar-desplegable-content', '.bar-desplegable-button');
                    }

                    // Si estas vistas estÃ¡n vacÃ­as, borrar el block parent
                    // URL: /creacion-y-comunicacion
                    hideEmptyEventBlocks();

                    function hideEmptyEventBlocks() {
                        $('.post_content .view-eventos-facultad').each(function() {
                            var context = $(this);

                            if (!context.children().length) {
                                context.parents('.block').hide();
                            }
                        });

                        $('.post_content .field--name-field-texto-inferior').each(function() {
                            var context = $(this);
                            // se agrego el $('body').hasClass('page-faculties') para que no borrara los elementos del home
                            if (!context.next().length && $('body').hasClass('page-faculties')) {
                                context.parents('.block').hide();
                            }
                        });
                    }

                    // ********************************************
                    // 1. ADMISIONES
                    // ********************************************

                    // ZZZ hack
                    // $('.page-admisiones-children .sidebar-menu').prepend('<h2 class="js-prepend">Admisiones</h2>');

                    if ($('.button-page-404').length) {
                        $('body').addClass('js-class-page-404');
                    }

                    // URL: /admisiones
                    var bgroupTabsAdmisiones = '.block-block-groupeb507b8c-fbf1-4896-a3ba-3781f5a2d470',
                        jsAdmisionesView = bgroupTabsAdmisiones + ' > .block-inner > .block > .block-inner > div > .view',
                        jsAdmisionesButton = jsAdmisionesView + ' > .view-header',
                        jsAdmisionesContent = jsAdmisionesView + ' > .view-content';

                    //$(bgroupTabsAdmisiones).css('background', 'pink');
                    if ($(bgroupTabsAdmisiones).length) {
                        $(bgroupTabsAdmisiones).addClass('js-admisiones-blockgroup');
                        $(jsAdmisionesView).addClass('js-admisiones-view');
                        $(jsAdmisionesButton).addClass('js-admisiones-button');
                        $(jsAdmisionesContent).addClass('js-admisiones-content');

                        $(jsAdmisionesButton).hide();
                        // tabMaker(wrapper, tabContent, title, padding)
                        tabMaker(bgroupTabsAdmisiones, '.js-admisiones-content', '.js-admisiones-button', '15px');

                        // Agrupamos con masonry
                        $(bgroupTabsAdmisiones + ' .tabMakerContent').eq(1).addClass('tab-especializaciones');
                        $(bgroupTabsAdmisiones + ' .tabMakerContent').not('.tab-especializaciones').addClass('with-marronry');
                        $('.with-marronry .tabMakerContentInner > .views-row').addClass('marronry');
                        //startMasonry('.js-admisiones-blockgroup .tabMakerContentInner', '.marronry');

                        tabEspecializaciones('.tab-especializaciones');

                        var $container = $('.with-marronry .tabMakerContentInner');

                        $container.imagesLoaded(function() {
                            $container.masonry({
                                itemSelector: '.marronry',
                                percentPosition: true,
                                alignLTR: true,
                                //originLeft: "isOriginLeft",
                                //gutter: 15
                            }).resize();
                        });

                        // makeMasonryWorkWithInfiniteScroll
                        $container.masonry('reloadItems');
                        $container.masonry('layout').resize();


                        $(document).on('click', '.tabMakerTab, .tabMakerTabMobile', function() {
                            $container.masonry('reloadItems');
                            $container.masonry('layout').resize();
                        });

                        // Ocultamos las categorÃ­as que no tienen items
                        $('.marronry > .views-field-label').each(function() {
                            var context = $(this);

                            if (!context.next().length) {
                                context.parent().hide();
                            }
                        });
                    }




                    // URL: /apoyo-financiero
                    if ($('.agrupacion-pasos').length) {


                        // makeCarouselSingle(item, idName, interval)
                        makeCarouselSingle('.agrupacion-pasos .block', 'agrupacion-pasos', '0');
                        makeCarouselButtons('#agrupacion-pasos', 'agrupacion-pasos');
                        $('#agrupacion-pasos .left').addClass('flecha-delgada-izquierda');
                        $('#agrupacion-pasos .right').addClass('flecha-delgada-derecha');

                        $('.agrupacion-pasos .field--name-body, .agrupacion-pasos .field--name-field-body-2').matchHeight({
                            byRow: false,
                            property: 'height'
                        });

                        /*
                        $('.apoyo-paso-1 .field--name-body img')
                        	.parent()
                        	.addClass('col-2')
                        	.insertAfter('.apoyo-paso-1 .field--name-body');

                        $('.apoyo-paso-3 .field--name-body img')
                        	.parent()
                        	.addClass('col-2')
                        	.insertAfter('.apoyo-paso-3 .field--name-body');

                        $('.apoyo-paso-1 .field--name-body, .apoyo-paso-1 .col-2').matchHeight({
                        	byRow: true,
                        	property: 'height'
                        });

                        $('.apoyo-paso-3 .field--name-body, .apoyo-paso-3 .col-2').matchHeight({
                        	byRow: true,
                        	property: 'height'
                        });*/
                    }

                    // URL: /apoyo-financiero
                    if ($('.icetex-tabs').length) {
                        // tabMaker(wrapper, tabContent, title, padding)
                        tabMaker('.icetex-tabs', '.paragraph--type--title-tags-apoyo-financiero', '.field--name-field-titulo-tag-apoyo-financier .field__item', '15px');
                    }

                    // URL: /centro-de-lenguas
                    if ($('.centro-lenguas-home').length) {
                        makeCarouselSingle('.grupo-datos-cursos .block', 'grupo-datos-cursos', '4000');
                        makeCarouselButtons('#grupo-datos-cursos', 'grupo-datos-cursos');

                        $('#grupo-datos-cursos .left').addClass('flecha-delgada-izquierda');
                        $('#grupo-datos-cursos .right').addClass('flecha-delgada-derecha');
                    }
                    // URL: /talento-humano/caja-compensacion
                    if ($('.caja-compensacion').length) {
                        makeCarouselSingle('.grupos-caja-compensacion .paragraph', 'grupo-slides-caja', '0');
                        makeCarouselButtons('#grupo-slides-caja', 'grupo-slides-caja');

                        $('#grupo-slides-caja .left').addClass('flecha-delgada-izquierda');
                        $('#grupo-slides-caja .right').addClass('flecha-delgada-derecha');
                    }
					
					// URL: /talento-humano/trabaje-con-nosotros
					var trabajeBlock1 = '.block-views-blockofertas-trabaje-con-nosotros-block-1';
					if ($(trabajeBlock1).length) {
						wrapViewResults('h3', 1);
						desplegableMaker(trabajeBlock1, '.wrapper-level-1', '.tab-content-level-1', 'h3', 'desplegable-open', false, 1);
					}
					
					

                    // URL: /admisiones/pregrado
                    // http://ubosque.d8.seedlabs.co/admin/structure/paragraphs_type/fechas_maestrias_mayor_posgrados/display/default
                    // http://ubosque.d8.seedlabs.co/admin/structure/paragraphs_type/fechas_maestria_posgrados/display/default
                    if ($('.acordeon-fechas').length) {
                        // desplegableMaker(wrapper, parent, tabContent, title)
                        desplegableMaker('.acordeon-fechas', '.paragraph--type-fechas-facultad-ser-pilo-paga', '.field--name-field-pregrados-paragraphs', '.field--name-field-facultades-paragraphs', 'desplegable-open-1', false, 1);
                        desplegableMaker('.field--name-field-pregrados-paragraphs', '.field__item', '.formato-labels-children', '.field--name-field-pregrados', 'desplegable-open-2', false);
                    }


                    // FACULTADES
                    // URL: /creacion-y-comunicacion/, /educacion
                    // Si estos 2 bloques existen, ocultar product-basic
                    if ($('.block-block-content4b28aa39-9148-4bd5-83c9-e7e89eec5bd4').length) {
                        if (($('.view-id-productos_acad_facultad_centro.view-display-id-block_1').children().length == 0) && ($('.view-id-productos_acad_en_facultad_derecha.view-display-id-block_1').children().length == 0)) {
                            $('.block-block-content4b28aa39-9148-4bd5-83c9-e7e89eec5bd4, .block-views-blockproductos-acad-facultad-centro-block-1, .block-views-blockproductos-acad-en-facultad-derecha-block-1').hide();
                        }
                    }

                    if ($('.block-views-blockview-ubosque-fechas-inscripcion-pre-pos-block-1')) {
                        var firstLevelView = '.view-view-ubosque-fechas-inscripcion-pre-pos.view-display-id-block_1',
                            firstLevelViewsRow = firstLevelView + ' > .view-content > .views-row',
                            firstLevelButton = firstLevelViewsRow + ' > .views-field-label',
                            firstLevelContent = firstLevelViewsRow + ' > .views-field-view',
                            secondLevelView = '.view-view-ubosque-fechas-inscripcion-pre-pos.view-display-id-block_2',
                            secondLevelViewsRow = secondLevelView + ' > .view-content > .views-row',
                            secondLevelButton = secondLevelViewsRow + ' > div > span > .views-field-label',
                            secondLevelContent = secondLevelButton + ' + .wrapper-info';

                        function makeEasyThisViewAddingClasses(arg1, arg2, arg3, arg4, arg5) {
                            $(arg2).addClass(arg1 + '-level-view');
                            $(arg3).addClass(arg1 + '-level-views-row');
                            $(arg4).addClass(arg1 + '-level-button');
                            $(arg5).addClass(arg1 + '-level-content');
                        }

                        $('.second-level-content').addClass('formato-labels-children');
                        makeEasyThisViewAddingClasses('first', firstLevelView, firstLevelViewsRow, firstLevelButton, firstLevelContent);
                        makeEasyThisViewAddingClasses('second', secondLevelView, secondLevelViewsRow, secondLevelButton, secondLevelContent);


                        // With specific classes it's easy to use this function
                        // desplegableMaker(wrapper, parent, tabContent, title)
                        desplegableMaker(firstLevelView, '.first-level-views-row', '.first-level-content', '.first-level-button', 'desplegable-open-1');
                        desplegableMaker(secondLevelView, '.second-level-views-row', '.second-level-content', '.second-level-button', 'desplegable-open-2');
                    }


                    // URL: /admisiones/posgrado
                    if ($('.block-views-blockview-ubosque-fechas-inscripcion-posgrado-block-1').length) {
                        var firstLevelView = '.view-view-ubosque-fechas-inscripcion-posgrado.view-display-id-block_1',
                            firstLevelViewsRow = firstLevelView + ' > .view-content > .views-row',
                            firstLevelButton = firstLevelViewsRow + ' > .views-field-label',
                            firstLevelContent = firstLevelViewsRow + ' > .views-field-view';

                        $(firstLevelButton).each(function() {
                            $(this).nextAll()
                                .wrapAll('<div class="first-level-content"><div class="second-level-view"></div></div>');
                        });

                        var secondLevelView = '.second-level-view',
                            secondLevelViewsRow = secondLevelView + ' > .views-field',
                            secondLevelButton = secondLevelViewsRow + ' .field-content > .view > .view-header',
                            secondLevelContent = secondLevelViewsRow + ' .field-content > .view > .view-content',
                            thirdLevelView = '.third-level-view', // No existe el div, lo agregaremos despuÃ©s con wrapInner
                            thirdLevelViewsRow = thirdLevelView + ' > .views-row',
                            thirdLevelButton = thirdLevelViewsRow + ' > div > span > .views-field-label',
                            thirdLevelContent = thirdLevelButton + ' + .wrapper-info';

                        function makeEasyThisViewAddingClasses(arg1, arg2, arg3, arg4, arg5) {
                            $(arg2).addClass(arg1 + '-level-view');
                            $(arg3).addClass(arg1 + '-level-views-row');
                            $(arg4).addClass(arg1 + '-level-button');
                            $(arg5).addClass(arg1 + '-level-content');
                        }

                        $('.second-level-content').addClass('formato-labels-children');
                        $(secondLevelView).addClass('posgrado-view');
                        $(secondLevelContent).wrapInner('<div class="third-level-view" />');
                        makeEasyThisViewAddingClasses('first', firstLevelView, firstLevelViewsRow, firstLevelButton, firstLevelContent);
                        makeEasyThisViewAddingClasses('second', secondLevelView, secondLevelViewsRow, secondLevelButton, secondLevelContent);
                        makeEasyThisViewAddingClasses('third', thirdLevelView, thirdLevelViewsRow, thirdLevelButton, thirdLevelContent);



                        // With specific classes it's easy to use this function
                        // desplegableMaker(wrapper, parent, tabContent, title)
                        desplegableMaker(firstLevelView, '.first-level-views-row', '.first-level-content', '.first-level-button', 'desplegable-open-1');
                        desplegableMaker(secondLevelView, '.second-level-views-row', '.second-level-content', '.second-level-button', 'desplegable-open-2');
                        desplegableMaker(thirdLevelView, '.third-level-views-row', '.third-level-content', '.third-level-button', 'desplegable-open-3');

                    }

                    // URL: /admisiones/posgrado
                    if ($('.fechas-posgrado').length) {
                        // 1er nivel, 2do nivel, 3er nivel
                        desplegableMaker('.fechas-posgrado', '.paragraph--type-fechas-maestrias-mayor-posgrados', '.field--name-field-maestrias-mayor-posgrado', '.field--name-field-maestrias-mayor', 'desplegable-open-1');
                        desplegableMaker('.field--name-field-maestrias-mayor-posgrado', '.paragraph--type-fechas-maestria-posgrados', '.field--name-field-posgrados', '.field--name-field-posgrado-paragraph', 'desplegable-open-2', false);
                        desplegableMaker('.field--name-field-posgrados', '.paragraph--type-fechas-admisiones-posgrado', '.formato-labels-children', '.field--name-field-pregrados', 'desplegable-open-3', false);
                    }

                    // URL: /admisiones/pregrado
                    // URL: /admisiones/posgrado
                    // URL: /pilo-bosque
                    if ($('.bloques-verticales').length) {
                        $('#block-creatucuentadeusuario-block, #block-creatucuentadeusuario').addClass('active');

                        $('.bloques-verticales .block').hover(function() {
                            $(this).addClass('active').siblings().removeClass('active');
                        });
                    }

                    // URL: /becas-estimulos
                    if ($('.becas-estimulos').length) {
                        $('.block-block-content2aabbd2c-b6c8-4dc0-9e67-08f73e1bbbaf').addClass('js-addClass-bloque-superior');

                        $('.js-addClass-bloque-superior .field--name-field-bea > .field__item:eq(0), .js-addClass-bloque-superior .field--name-field-bea > .field__item:eq(1)').matchHeight({
                            byRow: true,
                            property: 'height'
                        });
                    }


                    if ($('.dos-bloques-electivos').length) {
                        $('.block-blockgroup.dos-bloques-electivos .block-consulta .block-inner').matchHeight({
                            byRow: true,
                            property: 'height'
                        });
                    }

                    if ($('.estilo-0006').length) {
						$('.estilo-0006').each(function() {
							var context = $(this);
							if (context.find('.field--name-field-body h2').length) {
								context.find('.field--name-field-title').remove();
							}
						});
						
                        $('.estilo-0006 .block-inner').matchHeight({
                            byRow: true,
                            property: 'height'
                        });
                    }


                    // ******************* END: 1. ADMISIONES **********************


                    // ******************* START: 3. INVESTIGACIONES **********************


                    // URL: /investigaciones
                    $('.page-investigaciones.home .view-id-nuestro_equipo.view-display-id-block_2 .view-content').owlCarousel({
                        responsive: {
                            // breakpoint from 0 up
                            0: {
                                items: 1
                            },
                            // breakpoint from 480 up
                            480: {
                                items: 3
                            },
                            768: {
                                items: 5
                            }
                        },
                        autoHeight: false,
                        autoHeightClass: 'owl-height',
                        navText: ''
                    });
					
					$('.page-investigaciones.home  .block.estilo-0013d .block-inner').matchHeight();
					
					
					// URL: /investigaciones/buscar-visibilidad
					if ($('.page-investigaciones.visibilidad').length) {
						// Hacemos este wrap, para que el tabMaker pueda seleccionar el block con sus clases CSS
						$('.content6 .bosque-form-1').each(function() {
							$(this).wrap('<div class="js-block-wrapper" />');
						});
						tabMaker('.content6 > .block-blockgroup > .block-inner', '.js-block-wrapper', 'h2', '0');
						
						$('.content6 .tabMakerTab').each(function() {
							$(this).wrapInner('<div class="inner" />');
						})
					}

                    // URL: /investigaciones/vicerrectoria-investigaciones
                    $('.page-investigaciones.vicerrectoria .estilo-0013 .block-inner').matchHeight({
                        byRow: true,
                        property: 'height'
                    });

                    $('.view-nuestro-equipo.view-display-id-block_2 .view-content').owlCarousel({
                        responsive: {
                            // breakpoint from 0 up
                            0: {
                                items: 1
                            },
                            // breakpoint from 480 up
                            480: {
                                items: 3
                            },

                            768: {
                                items: 4
                            }
                        },
                        autoHeight: false,
                        autoHeightClass: 'owl-height',
                        navText: ''
                    });

                    // URL: /investigaciones/sitiio
                    $('.sitiio .estilo-0013b').matchHeight({
                        byRow: true,
                        property: 'height'
                    });

                    // URL: /investigaciones/grupos-investigacion
                    if ($('.page-investigaciones.grupos-investigacion').length) {
                        // desplegableMaker(wrapper, parent, tabContent, title, activeClass, openFirst);
                        desplegableMaker('.acordeon-grupos-investigacion', '.views-row', '.text-content', '.field--name-field-title');
                        desplegableMaker('.acordeon-investogaciones-laboratorios', '.views-row', '.text-content', '.field--name-field-title');
                    }

                    if ($('.block-accordion').length) {
                        desplegableMaker('.block-accordion', '.paragraph', '.field--name-field-contenido-bloque', '.field--name-field-title');
                    }

					// URL: /investigaciones/documentos-formatos
					if ($('.page-investigaciones.documentos-formatos').length) {
						desplegableMaker('.content2', '.block', '.text-content', '.field--name-field-title2');
					}

                    // URL: /investigaciones/productos-investigacion
                    var productosInv1 = '.view-investigaciones-productos-destacados .view-content .views-row';
                    $(productosInv1 + ':eq(0)').addClass('active');
                    $(productosInv1).hover(function() {
                        $(this).addClass('active').siblings().removeClass('active');
                    });

                    if ($('.view-investigaciones-productos-destacados1').length) {
                        var $container = $('.view-investigaciones-productos-destacados');

                        $container.imagesLoaded(function() {
                            $container.masonry({
                                itemSelector: '.views-row',
                                percentPosition: true,
                                alignLTR: true,
                                //originLeft: "isOriginLeft",
                                //gutter: 15
                            }).resize();
                        });

                        // makeMasonryWorkWithInfiniteScroll
                        $container.masonry('reloadItems');
                        $container.masonry('layout').resize();
                    }

                    // URL: /investigaciones/gestion-proyecto-investigacion
                    //$('')
                    // desplegableMaker(wrapper, parent, tabContent, title, activeClass, openFirst);
                    desplegableMaker('.gestion-proyectos .content1', '.block', '.text-content', '.field--name-field-title2');


                    // URL: /investigaciones/convocatorias-investigacion
                    desplegableMaker('.view-convocatorias.view-display-id-block_9', '.views-row', '.text-content', '.field--name-node-title');


                    // ******************* START: 5. NUESTRO BOSQUE **********************

                    // desplegableMaker(wrapper, parent, tabContent, title, activeClass, openFirst)
                    desplegableMaker('.field--name-field-dato-paragraphs', '.field__item', '.wrapper-desplegable-nivel-1', '.field--name-field-areas-directivos', 'desplegable-open', false, 1);


                    // URL: /nuestro-bosque/documentos-de-consulta
                    // 5.5 documentos de consulta (hay que mejorar este cÃ³digo)
                    function documentosConsulta() {
                        $('.documentos-consulta').addClass('custom-js documentosConsulta');
                        $('.documentos-consulta .field--name-field-documentos-de-consulta').each(function() {
                            var context = $(this),
                                viewsRow = context.parent().parent(),
                                cssClass = context.text().replace(/ /g, '-').toLowerCase();

                            // context.insertBefore(viewsRow);

                            viewsRow.addClass(cssClass);
                            // viewsRow.attr('data-class', cssClass);
                        });

                        $('.documentos-consulta .views-row.polÃ­ticas-institucionales')
                            .wrapAll('<div class="desplegable-wrapper des-politicas"><div class="toggle-content"></div>');

                        $('.documentos-consulta .views-row.estatutos-y-reglamentos')
                            .wrapAll('<div class="desplegable-wrapper des-estimulos"><div class="toggle-content"></div>');

                        $('.documentos-consulta .views-row.planes-de-desarrollo')
                            .wrapAll('<div class="desplegable-wrapper des-planesdesarrollo"><div class="toggle-content"></div>');

                        $('.documentos-consulta .views-row.informaciÃ³n-legal')
                            .wrapAll('<div class="desplegable-wrapper des-informaciÃ³n"><div class="toggle-content"></div>');

                        $('.des-planesdesarrollo').insertBefore('.des-informaciÃ³n');


                        $('.documentos-consulta .toggle-content').each(function() {
                            var context = $(this),
                                taxonomy = context.find('.views-row:eq(0) .field--name-field-documentos-de-consulta');

                            taxonomy.addClass('taxonomy-button').insertBefore(context);
                        });

                        // desplegableMaker(wrapper, parent, tabContent, title, activeClass, openFirst);
                        desplegableMaker('.view-view-0005-documentos-consulta.view-display-id-block_1', '.desplegable-wrapper', '.toggle-content', '.taxonomy-button', 'desplegable-open', false, 1);
						$('.view-view-0005-documentos-consulta.view-display-id-block_1 .toggle-content').wrapInner('<div class="js-wrapper">');

                    }

                    documentosConsulta();

                    // ******************* END: 5. NUESTRO BOSQUE **********************

                    // ******************* START: 5.4 NUESTRO BOSQUE: CatÃ¡logo de Publicaciones **********************

                    // URL: /nuestro-bosque
                    $(document).on('click', '.estilo-0003 .field--type-image', function() {
                        var
                            context = $(this),
                            url = context.next().find('a').attr('href');

                        window.location = url;
                    });

                    // URL: /nuestro-bosque/catalogo
                    var catNumb = 0;
					
					$('.block-carousel .view-content').owlCarousel({
                        responsive: {
                            // breakpoint from 0 up
                            0: {
                                items: 1
                            },
                            // breakpoint from 480 up
                            480: {
                                items: 3
                            },

                            768: {
                                items: 5
                            }
                        },
                        autoHeight: false,
                        autoHeightClass: 'owl-height',
                        navText: ''
                    });
					

                    // view-catalogo-home-informacion view-id-catalogo_home_informacion view-display-id-block_1
                    /*$('.block-carousel').each(function() {
                        var
                            context = $(this),
                            idName = 'carousel-' + (++catNumb);

                        if ($(window).width() > 788) {
                            makeCarouselMultiple('.block-carousel .view-display-id-block_' + catNumb + ' .views-row', idName, 5, '0');
                        }
                        if ($(window).width() < 788 && $(window).width() > 380) {
                            makeCarouselMultiple('.block-carousel .view-display-id-block_' + catNumb + ' .views-row', idName, 3, '0');
                        }
                        if ($(window).width() < 380) {
                            makeCarouselMultiple('.block-carousel .view-display-id-block_' + catNumb + ' .views-row', idName, 1, '0');
                        }

                        makeCarouselButtons('.carousel-inner', idName);
                    });*/
                    addPlaceholder('.block-views.block-views-exposed-filter-blocksearch-catalogo-page-1 .form-item-search-api-fulltext .form-text', 'Ej.:search')
                        // ******************* END: 5.4 NUESTRO BOSQUE: CatÃ¡logo de Publicaciones **********************


                    // ******************* START: 10. InternacionalizaciÃ³n CONVENIOS  **********************

                    $('.page-internacionalizacion .field--name-field-enlace a').removeAttr('href');

                    // URL: /internacionalizacion
                    var carouselS = 1;
                    $('.carousel-semestres .field--name-body .field__item').each(function() {
                        var context = $(this);
                        $('<div class="carousel-label"><span>' + (carouselS++) + '</span> <b>Semestre</b></div>')
                            .prependTo(context);
                    });
                    $('.carousel-semestres .field--name-body').owlCarousel({
                        responsive: {
                            // breakpoint from 0 up
                            0: {
                                items: 2
                            },
                            // breakpoint from 480 up
                            480: {
                                items: 3
                            },

                            768: {
                                items: 5
                            }
                        },
                        autoHeight: false,
                        autoHeightClass: 'owl-height',
                        navText: ''
                    });

                    $('.carousel-semestres .field--name-body .field__item').matchHeight({
                        byRow: true,
                        property: 'height'
                    });

                    // URL: /bienestar-universitario/grupos-universitarios
                    $('.carousel-semestres .view-content').owlCarousel({
                        responsive: {
                            // breakpoint from 0 up
                            0: {
                                items: 1
                            },
                            // breakpoint from 480 up
                            480: {
                                items: 3
                            }
                        },
                        autoHeight: false,
                        autoHeightClass: 'owl-height',
                        navText: ''
                    });

                    // URL: /bienestar-universitario/deportes
                    $('.view-deportes-.view-display-id-block_1 .view-content').owlCarousel({
                        responsive: {
                            // breakpoint from 0 up
                            0: {
                                items: 1
                            },
                            // breakpoint from 480 up
                            480: {
                                items: 3
                            }
                        },
                        autoHeight: false,
                        autoHeightClass: 'owl-height',
                        navText: ''
                    });


                    // URL: /bienestar-universitario/club-de-beneficios
                    clubBeneficiosGrilla();

                    function clubBeneficiosGrilla() {
                        // Solo para llenar data, borrar despuÃ©s
						/*
                        for (var i = 0; i < 20; i++) {
                            $('<div class="views-row"><img src="/sites/default/files/2017-05/52e7d87431e93c375d00036f.jpg" alt="Beneficios Cine Colombia" typeof="Image" height="201" width="201"></div>')
                                .appendTo('.view-club-de-beneficios-bienestar-universitario .view-content');
                        }*/


                        $('.view-club-de-beneficios-bienestar-universitario .views-row:nth-of-type(4n+2)').attr('data-column', 1);
                        $('.view-club-de-beneficios-bienestar-universitario .views-row:nth-of-type(4n+3)').attr('data-column', 2);
                        $('.view-club-de-beneficios-bienestar-universitario .views-row:nth-of-type(4n+4)').attr('data-column', 3);
                        $('.view-club-de-beneficios-bienestar-universitario .views-row:nth-of-type(4n+5)').attr('data-column', 4);

                        var vistaClubBeneficios = '.view-club-de-beneficios-bienestar-universitario .views-row';


                        $(document).on('click', vistaClubBeneficios + ' img', function() {
                            var
                                context = $(this).parents('.views-row'), // cada views-row
                                hover = context.find('.text-content'), // el elemento que se desplegarÃ¡
                                hoverHeight = hover.outerHeight(), // el alto del elemento desplegable
                                column = context.attr('data-column'); // el nÃºmero de columna

                            context.siblings().css('top', 0).find(' .text-content').slideUp(); // Cerramos todo cuando se clickea otro views-row
                            context
                                .css('top', 0)
                                .nextAll('[data-column="' + column + '"]') // Seleccionamos los elementos siguientes de la misma columna
                                .css('top', hoverHeight) // y los empujamos para abajo
                                .parents('.view-content').css('padding-top', 0);

                            hover.slideDown(); // hacemos visible el .text-content del views-row actual

                            // No se estÃ¡n usando, pero ya quedan
                            $(vistaClubBeneficios).removeClass('active');
                            context.addClass('active');

                            // Como estos moviendo las columnas con css top, es posible que cuando se de click a la penÃºltima
                            // fila, y en la Ãºltima fila no exista otro views-row de la misma columna
                            // es posible que aparezca cortado
                            // hay que hacer crecer el contenedor
                            // no sÃ© todavÃ­a si es que hay que agregarle un else
                            if (context.nextAll('[data-column="' + column + '"]').length) {
                                $('.view-club-de-beneficios-bienestar-universitario .view-content').css('padding-bottom', hoverHeight);
                            }

                        });

                        $(document).on('click', '.close-this', function() {
                            $('[data-column]').css('top', 0);
                            $(vistaClubBeneficios + ' .text-content').slideUp();
                            $(this).parents('.views-row').removeClass('active');
                        });
                    }



                    // URL: /internacionalizacion/convenios
                    if ($('.tabs-formularios').length) {
                        tabMaker('.tabs-formularios', '.block-webform', 'h2', '15px');
                    }


                    function resultLength() {
                        $('.result-length').text($('.page-internacionalizacion .tabla-bosque .views-row').length);
                    }

                    if ($('.page-internacionalizacion .tabla-bosque').length) {
                        $('.result-length').addClass('check-custom-js-function-resultLength');
                        setInterval(function() {
                            resultLength();
                        }, 500);
                    }

                    $('.page-internacionalizacion .tabla-bosque .views-row').each(function() {
                        var
                            context = $(this),
                            area = context.find('.field--name-field-area-de-conocimiento'),
                            programa = context.find('.field--name-field-grupos-pregrado'),
                            pais = context.find('.field--name-field-pais .field__item');

                        stringArea = area.text().replace(/\s/g, '-').toLowerCase();
                        stringPrograma = programa.text().replace(/\s/g, '-').toLowerCase();
                        stringPais = pais.text().replace(/\s/g, '-').toLowerCase();

                        context.attr('data-area', stringArea);
                        context.attr('data-programa', stringPrograma);
                        context.attr('data-pais', stringPais);

                        context.attr('data-area-visible', '');
                        context.attr('data-programa-visible', '');
                        context.attr('data-pais-visible', '');
                    });


					/*
                    $('#filtro-pais li').click(function() {
                        var context = $(this),
                            contextText = context.text().replace(/\s/g, '-').toLowerCase();
                        // $('.tabla-bosque .views-row').hide();
                        $('[data-pais-visible]').attr('data-pais-visible', false);
                        $('[data-pais="' + contextText + '"]').attr('data-pais-visible', true); //.show();
                    });

                    filtroConveniosClick('#filtro-area li', 'area');
                    filtroConveniosClick('#filtro-programa li', 'programa');
                    filtroConveniosClick('#filtro-pais li', 'pais');

                    $('.result-length').text($('.tabla-bosque .views-row:visible').length);

                    function filtroConveniosClick(selector, dataName) {
                        $(document).on('click', selector, function() {
                            var
                                context = $(this),
                                contextText = context.text().replace(/\s/g, '-').toLowerCase();
                            $('[data-' + dataName + '-visible]').attr('data-' + dataName + '-visible', false);
                            $('[data-' + dataName + '="' + contextText + '"]').attr('data-' + dataName + '-visible', true);

                            if (context.hasClass('all')) {
                                $('[data-' + dataName + '-visible]').attr('data-' + dataName + '-visible', 'true');
                            }
                        });
                    }
					*/

                    $(document).on('click', '.filter-action a', function() {
                        $('.tabla-bosque .views-row').hide();

                        /*
                        $('[data-area-visible="true"][data-programa-visible="false"][data-pais-visible="false"]').show();
                        $('[data-area-visible="false"][data-programa-visible="true"][data-pais-visible="false"]').show();
                        $('[data-area-visible="false"][data-programa-visible="false"][data-pais-visible="true"]').show();
                        $('[data-area-visible="true"][data-programa-visible="true"][data-pais-visible="true"]').show();
                        */

                        $('[data-area-visible="true"]').show();
                        $('[data-programa-visible="true"]').show();
                        $('[data-pais-visible="true"]').show();
                        $('.result-length').text($('.tabla-bosque .views-row:visible').length);
                    });



                    // tabMaker(wrapper, tabContent, title, padding);
                    if ($('.tabs-acordeon-views').length) {
                        tabMaker('.tabs-acordeon-views', '.acordeon-views', 'h2', '15px');
                    }
					
					// /internacionalizacion/movilidad-estudiantil
					if ($('.block-block-contentd9b72ac5-0175-440c-ba03-142e6d33b15c').length) {
						tabMaker('.field--name-field-movilidad-estudiantil', '.field--name-field-movi', '.field--name-field-title', '15px');
						desplegableMaker('.field--name-field-movilidad-estudiantil .tabMakerContentInner', '.field__item', '.field--name-field-requisitos', '.field--name-field-acerca-de', 'desplegable-open', false, 1);
					}

                    // ******************* END: 10. InternacionalizaciÃ³n CONVENIOS  **********************

					// EVENTOS

					if ($('.page-node-type-evento-especial').length) {
						makeCarouselSingle('.field--name-field-imagenes-multiples .field__item', 'eventos-slider', '0');
						makeCarouselButtons('#eventos-slider', 'eventos-slider');
						
						makeCarouselSingle('.field--name-field-body-images .field__item', 'sobre-el-evento-slider', '0');
						makeCarouselButtons('#sobre-el-evento-slider', 'sobre-el-evento-slider');
					
						$('<img src="/themes/custom/seed_ubosque/images/svg/flecha-svg-left.svg" />').appendTo('.left');
						$('<img src="/themes/custom/seed_ubosque/images/svg/flecha-svg-right.svg" />').appendTo('.right');
					
						//tabMaker(wrapper, tabContent, title, padding);
	               	 	tabMaker('.field--name-field-day-events', '.desplegable-content', '.field--name-field-days', '0');
						
						$('.field--name-field-conferencistas').owlCarousel({
						      responsive: {
						          // breakpoint from 0 up
						          0: {
						              items: 1
						          },
						          // breakpoint from 480 up
						          480: {
						              items: 2
						          }
						      },
						      autoHeight: false,
						      autoHeightClass: 'owl-height',
						      navText: ''
						  
						});
					}
					
					// URL: /node/965
					if ($('.page-node-type-evento-especial-dos').length) {
						tabMaker('.field--name-field-cronograma-blog-dos > .field__items', '.field--name-field-contenido', '.field--name-field-list-days-two', '0');
					}
					
					
					// URL: /blog-dos
					$('.views-first-new.blog-two').insertBefore('.sidebar-first');
					
					// URL: /blog-dos/capacitacion-docentes
					if ($('.grouptype-blog_dos').length) {
						$('.field--name-field-tags').insertAfter('.field--name-node-title');
					}
					

                    // ******************* START: 11. Ã‰xito Estudiantil  **********************
                    var imagesEstilo18 = $('.estilo-0018 .field--name-field-images .field__item');
                    imagesEstilo18.addClass('image-move').filter(':gt(0)').each(function() {
                        var num = $(this).index();
                        $(this).attr('data-num', num);
                    });
                    $('.estilo-0018 .field--name-field-images .field__item:first-child').addClass('active');
                    $(document).on('click', '.estilo-0018 .field--name-field-images .field__item', function() {
                        var
                            context = $(this),
                            index = context.index(),
                            i = 1;

                        context
                            .addClass('active')
                            .removeClass('num-' + index)
                            .siblings().removeClass('active');

                        imagesEstilo18.removeAttr('data-num');
                        imagesEstilo18.each(function() {
                            var
                                subContext = $(this),
                                subIndex = subContext.index() + 1;

                            if (subContext.index() < index) {
                                subContext.attr('data-num', subIndex);
                            } else if (subContext.index() > index) {
                                subContext.attr('data-num', subIndex - 1);
                            }
                        });
                    });




                    // URL: http://uat_ubosque.d8.seedoven.co/exito-estudiantil
					$('.block-content--type-_016-slider-exito-estudiantil .field--name-field-dato-paragraphs').owlCarousel({
					   responsive: {
					       // breakpoint from 0 up
					       0: {
					          items: 1
					          },
					       // breakpoint from 480 up
					       480: {
							   items: 2
					       },
						   768: {
							   items: 4
						   }
					    },
					    autoHeight: false,
					    autoHeightClass: 'owl-height',
					    navText: ''
					 });

					 // URL: http://uat_ubosque.d8.seedoven.co/exito-estudiantil
					 $('.page-exito-estudiantil.home .owl-item').matchHeight();
					 

                    // ******************* END: 11. Ã‰xito Estudiantil  **********************


                    // ******************* START: 12. Bienestar  **********************
					// URL: /bienestar-universitario
					 var vistaFiltro = '.view-filtro-facultades-semana-induccion-bienestar-u';
					 if ($('.view-filtro-facultades-semana-induccion-bienestar-u').length) {
						 var
						 viewContent = $(vistaFiltro + ' .view-content'),
						 viewHeader = $(vistaFiltro + ' .view-filtro-selected'),
						 viewsRow = $(vistaFiltro + ' .views-row'),
						 viewsRowTitle = '.views-field-field-pdf-facultades-1';
						 
						 // viewHeader.text(Drupal.t('Elegir mi Facultad'));
						 
						 $(viewHeader).click(function() {
						 	viewContent.slideToggle();
						 });
						 
						 $(viewsRow).click(function() {
 							var
 							context = $(this);
 							title = context.find(viewsRowTitle);
							 
 							viewHeader.text(title.text());
							viewContent.slideUp();
						 });
					 } 
					 
                    // URL: /bienestar-universitario/salud
                    if ($('.block-content--type-_014-tabs-servicios-horarios').length) {
                        tabMaker('.salud-servicios .block-content', '.desplegable-content', '.field--name-field-title', '15px');
                        tabMaker('.salud-programas .block-content', '.desplegable-content', '.field--name-field-title', '0');
						
						$('.salud-servicios, .salud-programas').find('.tabMakerTab').wrapInner('<div class="inner" />');
                    }

                    // URL: /bienestar-universitario/cultura-recreacion
                    if ($('.cultura-recreacion').length) {
                        tabMaker('.content3', '.block', 'h2', '15px');
                    }

					// URL: /blog-uno
					$('.views-sub-news .text-content').matchHeight({
						byRow: true,
						property: 'height'
					});


                    // ******************* END: 12. Bienestar  **********************


                    // ******************* START: 13. El Bosque te acoge  **********************
					
					// URL: /internacionalizacion, /el-bosque-te-acoge
					$('.page-node-type-bosque-008-main-image #main .content, .page-node-type-bosque-008-main-image  .field--name-field-image img')
					.matchHeight();
					
					
                    var imagesInmuebleNode = $('.field--name-field-imagenes-multiples .field__item');
                    imagesInmuebleNode.addClass('image-move').filter(':gt(0)').each(function() {
                        var num = $(this).index();
                        $(this).attr('data-num', num);
                    });
                    $('.field--name-field-imagenes-multiples .field__item:first-child').addClass('active');
                    $(document).on('click', '.field--name-field-imagenes-multiples .field__item', function() {
                        var
                            context = $(this),
                            index = context.index(),
                            i = 1;

                        context
                            .addClass('active')
                            .removeClass('num-' + index)
                            .siblings().removeClass('active');

                        imagesInmuebleNode.removeAttr('data-num');
                        imagesInmuebleNode.each(function() {
                            var
                                subContext = $(this),
                                subIndex = subContext.index() + 1;

                            if (subContext.index() < index) {
                                subContext.attr('data-num', subIndex);
                            } else if (subContext.index() > index) {
                                subContext.attr('data-num', subIndex - 1);
                            }
                        });
                    });




                    // URL: /insertar/inmuebles-el-bosque-te-acoge, /node/add/inmuebles_el_bosque_te_acoje
                    $('<a id="terminos-open">Ver tÃ©rminos y condiciones</a>').appendTo('#edit-field-boolean-acepto-terminos-wrapper label');

                    // Carga el block modal-terminos-condiciones como modal al hacer click al link de los tÃ©rminos
                    $(document).on('click', '#terminos-open', function() {
                        loadModal('.modal-terminos-condiciones', 'terminos-modal');
                        $('#default-modal').modal('show');
                    })

                    // Colococa element dentro del modal de Bootstrap insertado cerca al footer del page.twig
                    function loadModal(element, cssClass) {
                        var element = $(element);
                        $('#default-modal').addClass(cssClass);
                        $('#default-modal .modal-body').html(element.html());
                    }

                    // $('modal-terminos-condiciones')

                    // ******************* START: 21. AUDIENCIA **********************
                    // URL: /audiencia/aspirantes
                    makeCarouselSingle('.field--name-field-body-slider .field__item', 'field--name-field-body-slider', '5000');
                    makeCarouselButtons('#field--name-field-body-slider', 'field--name-field-body-slider');
					
					if ($('.page-audiencias.aspirantes').length) {
						$('.block-views-blocknoticias-1-block-5-noticias-aspirantes .text-content')
							.matchHeight({
								byRow: true,
								property: 'height'
							});
					}
					
					// URL: /docentes
					$('.page-audiencias.docentes #block-subcolumnacentraldocentes .block .block-inner').matchHeight();
					
					

                    // ******************* END: 21. AUDIENCIA **********************

                    // URL: /creacion-y-comunicacion/carrera/diseno-de-comunicacion
                    if ($('.main-image').length) {
                        var secondLine = $('.field--name-field-titulo-sin-bold'),
                            secondLineLength = wordCount(secondLine.text()),
                            imageTextWrapper = $('.main-image .text-content');

                        if (secondLineLength > 1) {
                            secondLine.addClass('multi-words');
                            imageTextWrapper.addClass('second-line-has-more-than-1-word');
                        }

                        var snies = $('.field--name-field-bloque-legal-snies-'),
                            sniesLength = wordCount(snies.text());

                        if (sniesLength > 30) {
                            imageTextWrapper.addClass('snies-too-long');
                        }
                    }

                    // URL: /inscripciones/orientacion-especializada
                    if ($('.orientacion-especializada').length) {
                        var mainImageButton = '.node--type-pagina-basica-bosque .field--name-field-enlace a';

                        $(document).on('click', mainImageButton, function(e) {
                            e.preventDefault();
                            $('html, body').animate({
                                scrollTop: ($('.deseo-mayor-informacion').position().top)
                            }, 1500);
                        });
                    }
                    // URL: /inscripciones/programas-inmersion

                    if ($('.programa-inmersion').length) {
                        var mainImageButton = '.node--type-pagina-basica-bosque .field--name-field-enlace a';

                        $(document).on('click', mainImageButton, function(e) {
                            e.preventDefault();
                            $('html, body').animate({
                                scrollTop: ($('.deseo-mayor-informacion').position().top)
                            }, 1500);
                        });
                    }

                    // URL: /facultad/creacion-comunicacion/producto-academico/biparqueadero-t
                    if ($('.carousel-field').length) {
                        carouselField('proposito');
                    }

                    if ($('.page-node-type-productos-academicos').length) {
                        makeCarouselSingle('.purpose .field--name-field-proposito-productos-acad > .field__item', 'proposito-carousel', '0');
                        makeCarouselButtons('.purpose .field--name-field-imagen-programa', 'proposito-carousel');
                    }

                    // URL: /facultad/creacion-comunicacion/producto-academico/biparqueadero-t
                    if ($('.paragraph--type-slider-productos-aca-inf').length) {
                        makeCarouselMultiple('.paragraph--type-slider-productos-aca-inf', 'proceso-carousel', 3, '0');
                        makeCarouselButtons('#proceso-carousel', 'proceso-carousel');
                    }


					// ******************* START: 23. RESPONSABILIDAD **********************
					if ($('.page-responsabilidad-social').length) {
						tabMaker('.tabs-resposanbilidad-social', '.desplegable-content', '.field--name-field-title', '15px');
					}

					$('.block-views-blockhome-responsabilidad-social-block-4, .block-views-blockhome-responsabilidad-social-block-1, .block-views-blockhome-responsabilidad-social-block-2 img, .block-views-blockhome-responsabilidad-social-block-3 img').matchHeight({
						property: 'height',
						byRow: false
					})

                    if ($('.path-facultad').length) {

                        // $('.views-element-container').clone().insertAfter('.views-element-container');



                        $('<div class="category-tab">' + $('.view-calendario-academico-page.view-display-id-page_1 .views-row:eq(0) .field--name-field-noticias-taxonomia').text() + '</div>')
                            .insertBefore('.view-calendario-academico-page.view-display-id-page_1 > .view-content');

                        $('<div class="category-tab second">' + $('.view-calendario-academico-page.view-display-id-block_1 .views-row:eq(0) .field--name-field-noticias-taxonomia').text() + '</div>')
                            .insertBefore('.view-calendario-academico-page.view-display-id-block_1 .view-content');

                        //jQuery('.view-calendario-academico-page.view-display-id-block_1 .view-content').addClass('seconds');
                        //jQuery('.view-calendario-academico-page.view-display-id-block_1 .view-content').removeClass('view-content');

                        //desplegableMaker('.views-element-container', '.view-calendario-academico-page.view-display-id-page_1', '.view-content', '.category-tab' );
                        //desplegableMaker('.view-footer', '.view-calendario-academico-page.view-display-id-block_1', '.seconds', '.category-tab.second' );


                        $('#main .views-element-container').addClass('desple-1-wrapper');
                        $('#main .views-element-container > div').addClass('desple-1-inner');
                        $('#main .views-element-container > div > .category-tab').addClass('desple-1-button');
                        $('#main .views-element-container > div > .view-content').addClass('desple-1-content');

                        $('#main .view-footer').addClass('desple-2-wrapper');
                        $('#main .view-footer > .view').addClass('desple-2-inner');
                        $('#main .view-footer > .view > .category-tab').addClass('desple-2-button');
                        $('#main .view-footer > .view > .view-content').addClass('desple-2-content');

                        // desplegableMaker(wrapper, parent, tabContent, title)
                        desplegableMaker('.desple-1-wrapper', '.desple-1-inner', '.desple-1-content', '.desple-1-button', 'desplegable-open-1', true, 1);
                        desplegableMaker('.desple-2-wrapper', '.desple-2-inner', '.desple-2-content', '.desple-2-button', 'desplegable-open-2', false, 1);
                        // view view-calendario-academico-page view-id-calendario_academico_page view-display-id-page_1 js-view-dom-id-ff7533fefe53c360ff592b73d552391bfb2b09cfb3642426c8a294110c1d97a1
                    }


                    if ($('.page-node-type-acerca-de-la-facultad').length) {
                        tabMaker('.field--name-field-departamentos-de-la-facult', '.field--name-field-bloque-legal-snies-', '.field--name-field-titulo-del-tab', '15px');
                        $('.field--name-field-departamentos-de-la-facult .tabMakerWrapper + .field__label')
                            .insertBefore('.field--name-field-departamentos-de-la-facult .tabMakerWrapper');

                    }

                    // URL: /admisiones/, /programas-academicos
                    if ($('.section-oferta-academica').length) {
                        tabMaker('.section-oferta-academica', '.field--name-field-tab-programa', '.field--name-field-titulo-del-tab', '15px');
                    }

                    // TABS detalle catalogo
                    // URL: /nuestro-bosque/catalogo/it-performed
                    if ($('.catalogo-busqueda .field--name-field-tabs').length) {
                        tabMaker('.field--name-field-tabs', '.paragraph--type-tabs-especializacion', '.field--name-field-titulo-tab-pregrado', '15px');
                    }

                    // URL: /posgrados
                    if ($('.block-block-group3783f586-588d-4a60-bf34-76ab3f107625').length) {

                        // Solo uso una funciÃ³n para poder reutilizar la variable
                        function newScope() {
                            var bgroupTabsAdmisiones = '.block-block-group3783f586-588d-4a60-bf34-76ab3f107625',
                                jsAdmisionesView = bgroupTabsAdmisiones + ' > .block-inner > .block > .block-inner > div > .view',
                                jsAdmisionesButton = jsAdmisionesView + ' > .view-header',
                                jsAdmisionesContent = jsAdmisionesView + ' > .view-content';

                            //$(bgroupTabsAdmisiones).css('background', 'pink');
                            if ($(bgroupTabsAdmisiones).length) {
                                $(bgroupTabsAdmisiones).addClass('js-admisiones-blockgroup');
                                $(jsAdmisionesView).addClass('js-admisiones-view');
                                $(jsAdmisionesButton).addClass('js-admisiones-button');
                                $(jsAdmisionesContent).addClass('js-admisiones-content');

                                $(jsAdmisionesButton).hide();
                                // tabMaker(wrapper, tabContent, title, padding)
                                tabMaker(bgroupTabsAdmisiones, '.js-admisiones-content', '.js-admisiones-button', '15px');


                                // Agrupamos con masonry
                                $(bgroupTabsAdmisiones + ' .tabMakerContent').eq(0).addClass('tab-especializaciones');
                                $(bgroupTabsAdmisiones + ' .tabMakerContent').not('.tab-especializaciones').addClass('with-marronry');
                                $('.with-marronry .tabMakerContentInner > .views-row').addClass('marronry');
                                //startMasonry('.js-admisiones-blockgroup .tabMakerContentInner', '.marronry');

                                tabEspecializaciones('.tab-especializaciones');

                                var $container = $('.with-marronry .tabMakerContentInner');

                                $container.imagesLoaded(function() {
                                    $container.masonry({
                                        itemSelector: '.marronry',
                                        percentPosition: true,
                                        alignLTR: true,
                                        //originLeft: "isOriginLeft",
                                        //gutter: 15
                                    }).resize();
                                });

                                // makeMasonryWorkWithInfiniteScroll
                                $container.masonry('reloadItems');
                                $container.masonry('layout').resize();


                                $(document).on('click', '.tabMakerTab, .tabMakerTabMobile', function() {
                                    $container.masonry('reloadItems');
                                    $container.masonry('layout').resize();
                                });


                                // Ocultamos las categorÃ­as que no tienen items
                                $('.marronry > .views-field-label').each(function() {
                                    var context = $(this);

                                    if (!context.next().length) {
                                        context.parent().hide();
                                    }
                                });
                            }
                        }
                        newScope();
                    }

                    // URL: /node/53
                    if ($('.page-node-type-practicas-profesionales').length) {
                        tabMaker('.field--name-field-tabs-pregrado-practicas', '> .field__item', '.field--name-field-titulo-tab-pregrado', '15px');
                    }

                    // URL: /node/53
                    if ($('.page-node-type-convenios').length) {
                        tabMaker('.field--name-field-tabs-pregrado-convocatoria', '> .field__item', '.field--name-field-titulo-tab-pregrado', '15px');
                    }

                    // URL: /facultad/creacion-comunicacion/diseno-industrial
                    //if ($('.page-faculties-pregrados').length) {

                    // page-faculties-grupos-1
                    if ($('.acerca-perfil-tabs').length) {
                        tabMaker('.acerca-perfil-tabs .field--name-field-tabs-acerca-de-pregrado', '> .field__item', '.field--name-field-titulo-tab-pregrado', '15px');
                    }

                    if ($('.informacion-adicional').length) {
                        $('.informacion-adicional .title-group').each(function() {
                            var context = $(this);

                            if (!context.next().length) {
                                context.remove();
                            }
                        });
                        tabMaker('.informacion-adicional .field--name-field-informacion-adicional-preg', '.content-group', '.title-group', '10px');

                        // Hace que siempre existan 2 fields, asÃ­ solo uno tenga contenido
                        $('.informacion-adicional .tabMakerContentInner').each(function() {
                            var context = $(this);

                            if (context.children().length == 1) {
                                $('<div class="field js- ooms" />').appendTo(context);
                            }
                        });

                    }
                    //remover tab
                    //url: http://uat_ubosque.d8.seedoven.co/cursos-preuniversitarios/curso-basico-preuniversitario
                    if (!$('.decidete .text-content .field--name-field-titulo-decidete').length) {
                        $('.decidete .text-content').remove();
                    }
                    if ($('.plan-estudios').length) {
                        //$('.decidete').remove();
                        tabMaker('.plan-estudios', '.field--name-field-asignaturas > .field__item', '.field--name-field-semestre .field__item', 0);
                        $('.field--name-field-plan-de-estudios').insertAfter('.plan-estudios .tabMakerTabs');

                        $('.plan-estudios .tabMakerTabMobile').wrapInner('<div class="wrapi"></div>');
                        $('<div class="tabtext title-semester">Semestre</div>').prependTo('.plan-estudios .tabMakerTabMobile');

                        // Este prepend malogra el lavalamp active al iniciar
                        $('<div class="title-semester">Semestre</div>').insertBefore('.plan-estudios .tabMakerTabs');
                        // Reseteamos tab a 0 para reparar el lavalamp
                        $('.plan-estudios .lavalamp-bar').css('left', $('.plan-estudios .tabMakerTab.lavalamp-active').position().left);
                    }



                    $('.decidete').wrapInner('<div class="js-decidete-inner" />');

                    if ($('.field--name-field-asignatura-detalles').length) {
                        desplegableMaker('.field--name-field-asignatura-detalles', '.field__item', '.text-content', '.field--name-field-titulo-tab-pregrado');
                    }

                    // URL: /facultad/creacion-y-comunicacion/arte-dramatico
                    if ($('.page-faculties-grupos-1').length) {
                        // tabMaker(@wrapper, @tabContent, @tabTitle, @espacioOpcional)


                        // Despliega el formulario
                        $(document).on('click', '.field--name-field-proceso a', function() {
                            $(this).toggleClass('abierto');
                            $('.form-inscription-process').slideToggle();
                        });

                        // Este es un cheat
                        $('.form-inscription-process')
                            .addClass('js-appended opened')
                            .insertAfter('.main-image');

                        $(htmlBtnClose).prependTo('.form-inscription-process');

                        $(document).on('click', '.form-inscription-process .close-cerrar', function() {
                            $('.form-inscription-process').slideUp();
                            $('.main-image a').removeClass('abierto');
                            $('.main-image a').removeClass('abierto');
                        });

                        // Este es otro cheat
                        $('.field--name-dynamic-token-fieldnode-malla-curricular')
                            .addClass('js-appended')
                            .insertBefore('.field--name-field-plan-de-estudios .field__label, .field--name-field-plan-de-estudios .field-label-above');
                    }




                    function formDesplegable() {
                        // Despliega el formulario
                        $(document).on('click', '.main-image a', function(e) {
                            e.preventDefault();
                            $(this).toggleClass('abierto');
                            $('.form-inscription-process').slideToggle();
                        });

                        // Este es un cheat
                        $('.form-inscription-process')
                            .addClass('js-appended opened')
                            .insertAfter('.main-image');


                        $(htmlBtnClose).prependTo('.form-inscription-process');

                        $(document).on('click', '.form-inscription-process .close-cerrar', function() {
                            $('.form-inscription-process').slideUp();
                            $('.main-image a').removeClass('abierto');
                            $('.main-image a').removeClass('abierto');
                        });
                    }

                    // URL: /internacionalizacion/movilidad-estudiantil
                    if ($('.movilidad-estudiantil.page-internacionalizacion').length) {
                        formDesplegable();
                    }

                    // URL: /internacionalizacion/becas-internacionales
                    if ($('.page-internacionalizacion.becas-internacionales').length) {
                        formDesplegable();
                    }

                    function wrapViewResults(h3, number) {
                        $(h3).each(function() {
                            var context = $(this);
                            context.nextUntil(h3).wrapAll('<div class="wrapper-level-' + number + '"><div class="tab-content-level-' + number + '"></div></div>');
                        });

                        $('.wrapper-level-' + number).each(function() {
                            var
                                context = $(this)
                            prev = context.prev();

                            prev.prependTo(context);
                        });
                    }

                    // 	URL: /bienestar-universitario
                    if ($('.home-bienestar-universitario.home').length) {
                        $('.content5').addClass('plan-estudios');


                        // tabMaker(wrapper, tabContent, title, padding)
                        // desplegableMaker(wrapper, parent, tabContent, title, activeClass, openFirst)
                        $('.block-views-blockagenda-semanas-bienestar-universitario-block-1').remove();


                        var wrapper = '.content5';
                        $(wrapper + ' .view-header').addClass('tab-button-level-1');
                        $(wrapper + ' .view-content').addClass('tab-content-level-1');
                        $('[href*="taxonomy"]').removeAttr('href').wrap('<div class="tab-button-level-2" />');
                        $(wrapper + ' h3').wrap('<div class="tab-button-level-3" />');

                        
                        wrapViewResults('.tab-button-level-2', 2);
                        wrapViewResults('.tab-button-level-3', 3);

                        tabMaker('.content5', '.tab-content-level-1', '.tab-button-level-1', 0);
                        desplegableMaker('.tabMakerContentInner', '.wrapper-level-2', '.tab-content-level-2', '.tab-button-level-2', 'desplegable-open-1');
                        desplegableMaker('.tabMakerContentInner', '.wrapper-level-3', '.tab-content-level-3', '.tab-button-level-3', 'desplegable-open-2');


                        $('.block-views-blockmes-actual-bienestar-universitario-block-1')
                            .addClass('field--name-field-plan-de-estudios')
                            .insertAfter('.plan-estudios .tabMakerTabs');
                        $('.plan-estudios .tabMakerTabMobile').wrapInner('<div class="wrapi"></div>');
                        $('<div class="tabtext title-semester">Semana</div>').prependTo('.plan-estudios .tabMakerTabMobile');
                        // $('.tab-button-level-2').addClass('field--name-field-titulo-tab-pregrado');

                        // Este prepend malogra el lavalamp active al iniciar
                        $('<div class="title-semester">Semestre</div>').insertBefore('.plan-estudios .tabMakerTabs');
                        // Reseteamos tab a 0 para reparar el lavalamp
                        $('.plan-estudios .lavalamp-bar').css('left', $('.plan-estudios .tabMakerTab.lavalamp-active').position().left);
                    }

                    // URL: /bienestar-universitario/*
                    if ($('.page-bienestar-universitario').length) {
                        formDesplegable();
                    }
                    //URL:/talento-humano/comite-de-convivencia
                    if ($('.page-talento-humano').length) {
                        formDesplegable();
                    }
                    // URL: /facultad/creacion-comunicacion/arte-dramatico
                    if ($('.page-faculties-pregrados').length) {
                        menuTitleMaker('<div>Facultades</div>');
                    }

					// URL: /bienestar-universitario
					$('.home-bienestar-universitario .title-semester').text('Semana');

                    if ($(window).width() < 480) {
                        $('.with-marronry .tabMakerContentInner').removeAttr('style');
                    }


                    if ($('.view-id-repo_preguntas_frecuentes').length) {
                        desplegableMaker('.view-repo-preguntas-frecuentes', '.views-row', '.views-field-field-respuesta-de-pregunta', '.views-field-title');
                    }

                    //Construccion de select a partir de un <li>
                    //Url: /audiencia/estudiantes
                    if ($('.page-audiencias .view-filtro-estudiantes-audiencia').length) {


                        var listaFiltros = $('.page-audiencias .view-filtro-estudiantes-audiencia li a');
                        var select_filtro = $("<select></select>").attr("class", "select-filtro-estudiante-audiencia");
                        select_filtro.append('<option>Consultar la informaciÃ³n de mi Facultad</option>');
   
                        for (var i = 0; i < listaFiltros.length; i++) {
                            select_filtro.append("<option value='" + listaFiltros[i].href + "'>" + listaFiltros[i].innerText + "</option>");
                        }

                        $(".view-filtro-estudiantes-audiencia .view-content").append(select_filtro);

                    }

                    //Redireccionar al seleccionar una opcion
                    //Url: /audiencia/estudiantes
                    $('.page-audiencias .view-filtro-estudiantes-audiencia .select-filtro-estudiante-audiencia').change(function() {
                        location.href = ($(this).val());
                    });

                    //Duplicar bloque para responsive
                    //Url: /audiencia/estudiantes
                    if ($('.title-with-bocadillo.somos-bosque').length && $('.imagen-con-boton.electivas').length) {
                        var bloque = $('.title-with-bocadillo.somos-bosque').clone().addClass('desktop-hidden');
                        $('.imagen-con-boton.electivas').before(bloque);
                    }

                    //Duplicar bloque para responsive
                    //
                    if ($('.group-detalle-catalogo').length) {
                        var bloque1 = $('.group-detalle-catalogo .field--name-node-title').clone().addClass('desktop-hidden');
                        var bloque2 = $('.group-detalle-catalogo .field--name-field-bocadillo').clone().addClass('desktop-hidden');
                        var div = $("<div></div>").attr("class", "group-detalle-catalogo-2");
   
                        div.append(bloque1).append(bloque2);
                        $(".field--name-field-imagenes-multiples").before(div);
                    }

                    //Duplicar bloque para responsive
                    //Url: /audiencia/estudiantes
                    if ($('.title-with-bocadillo.somos-bosque').length && $('.imagen-con-boton.semana-induccion').length) {
                        var bloque = $('.title-with-bocadillo.somos-bosque').clone().addClass('desktop-hidden');
                        $('.imagen-con-boton.semana-induccion').before(bloque);
                    }

                    //Mover bloque banner
                    //Catalogo de publicaciones - busqueda
                    if ($('.main-image-form .banner-catalogo-editoriales').length) {
                        $('.sidebar-first').before($('.banner-catalogo-editoriales'));
                    }

                    //Estructura nuevo select
                    //Formulario el bosque te acoge
                    if ($('.select-ubosque').length) {
                        $('.select-ubosque select').SumoSelect();
                    }

                    //Reemplaza tag details por el tag div
                    //Formulario el bosque te acoge
                    /*
                    if($('.page-form-bosque-te-acoge------- .field--name-field-imagenes-multiples').length) {
                    	$('.field--name-field-imagenes-multiples details').replaceWith(function(){
                    		return $("<div />", {html: $(this).html()}).addClass('container-file-multiple');
                    	});
                    }

                    if($('.page-form-bosque-te-acoge .field--name-field-frase').length) {
                    	$('.field--name-field-frase label').text($('.field--name-field-frase .description').text());
                    }

                    if($('.page-form-bosque-te-acoge form').length) {
                    //	$('.page-form-bosque-te-acoge .node-inmuebles-el-bosque-te-acoje-form').before($('.page-form-bosque-te-acoge #main > .content >.block-block-content'));
                    }*/

                    //URL: /el-bosque-te-acoge
                    //Estructura para el banner de la pagina (imagen, formulario y texto)
                    if ($('.page-home-el-bosque-te-acoge').length) {
                        $('[value="All"]').text('Cualquiera').addClass('text-changed-by-js');
                        $('.main-bosque-acoge .form-select').SumoSelect();
                        $('.CaptionCont').each(function() {
                            var context = $(this),
                                label = context.parents('.SumoSelect').prev('label').text();

                            context.find('span').text(label);
                        });
                    }

                    if ($('.page-home-el-bosque-te-acoge .main-image').length) {
                        var div_container = $("<div></div>").addClass("container-form-filter");
                        var text = $('.node--type-pagina-basica-bosque >.main-image >.field--name-field-titulo-2');
                        var text2 = $('.node--type-pagina-basica-bosque .field--name-field-bocadillo-150');
                        var filtro = $('.block-views-exposed-filter-blockduplicado-de-filtro-inmuebles-el-bosque-te-acoge-page-1');
                        var button = $('.wrapper-enlace .field--name-field-enlace');
                        div_container.append(text).append(text2).append(filtro);
                        $('.node--type-pagina-basica-bosque >.main-image').append(div_container);
                        $('.block-views-exposed-filter-blockduplicado-de-filtro-inmuebles-el-bosque-te-acoge-page-1 form').append(button);

                    }

                    //URL: /el-bosque-te-acoge
                    //Texto boton del formulario el bosque te acoge
                    if ($('.page-home-el-bosque-te-acoge .container-form-filter .form-actions').length) {
                        $('.page-home-el-bosque-te-acoge .container-form-filter .form-actions input').val("Buscar");
                    }

                    //URL: /internacionalizacion
                    if ($('.page-internacionalizacion').length) {
                        $('.CaptionCont').each(function() {
                            var context = $(this),
                                label = context.parents('.SumoSelect').prev('label').text();

                            context.find('span').text(label);
                        });
                    }

                    //URL: /node/add/inmuebles_el_bosque_te_acoje
                    if ($('.page-form-bosque-te-acoge').length) {
                        $('.form-datos-personales .CaptionCont').each(function() {
                            var context = $(this),
                                label = context.parents('.SumoSelect').prev('label').text();

                            context.find('span').text(label);
                        });

                        $('.form-descripcion-inmueble .CaptionCont').each(function() {
                            var context = $(this);
                            context.find('span').text("Seleccione una opciÃ³n");
                        });
                    }
                }); // once
            }); // document.ready




            function wordCount(val) {
                var word = val.match(/\S+/g);
                return word ? word.length : 0;
            }

            function monthsHover() {
                $('.item-month-day').each(function() {
                    $(this)
                        .clone()
                        .appendTo($(this))
                        .wrap('<div class="js-hover-date" />');
                });
            }


            function formTextValue() {
                $('label').each(function() {
                    $(this).insertAfter($(this).next());
                    $(this).wrapInner('<span />');
                });

                $('.js-form-type-textarea label').each(function() {
                    $(this).insertAfter($(this).parents('.js-form-type-textarea').find('textarea'));
                });

                $('.form-text, .form-textarea, .form-email').each(function() {
                    var context = $(this);

                    // context.attr('placeholder', '');

                    context.blur(function() {
                        if ($(this).val()) {
                            $(this).addClass('filled');
                        } else {
                            $(this).removeClass('filled');
                        }
                    });

                    if ($(this).val()) {
                        $(this).addClass('filled');
                    }


                });


                //Checkbox
                jQuery('<label id="formulario-checkbox-error" style="display:none;">Este campo es obligatorio.</label>').insertAfter(jQuery('#edit-autorizo-a-la-universidad-el-bosque-para-el-envio-de-informacion').siblings('label.option'));
                //radiobutons
                jQuery('<label id="edit-radio-button" style="display:none; font-family:pt_serifitalic; font-size:12px;">Este campo es obligatorio.</label>').insertAfter(jQuery('#edit-opciones-estudiante').siblings('label.option'));

            }
            //Checkbox
            jQuery("#webform-submission-formulario-orientacion-especiali-form #edit-submit").click(function(event) {

                if (!(jQuery('#edit-autorizo-a-la-universidad-el-bosque-para-el-envio-de-informacion').prop('checked'))) {
                    jQuery("#formulario-checkbox-error").css({ "display": "block", "color": "red" });
                } else {
                    jQuery("#formulario-checkbox-error").css({ "display": "none" });
                }
                //radiobutons
                jQuery('#edit-opciones .form-radio').each(function(e) {
                    if (jQuery(this).prop('checked')) {
                        jQuery("#edit-radio-button").css({ "display": "none" });
                        return false;
                    } else {
                        jQuery("#edit-radio-button").css({ "display": "block", "color": "red" });
                    }
                });
            });

            //URL: /directorio/academicos
            //Desplegables
            jQuery('.views-label-field-detalle-academico').click(function() {
                if (globalFlag_directory == 0 || globalFlag_directory % 2 == 0) {
                    if ($(this).hasClass("open-desplegable")) {
                        $(this).parent().find('.field-content-detalle').slideUp();
                    } else {
                        $(this).parent().find('.field-content-detalle').slideDown();
                    }
                    $(this).toggleClass("open-desplegable");
                }
                globalFlag_directory++;
            })
            if (!$('.view-preguntas-frecuentes-por-facultad').children().length) {
                $('.view-preguntas-frecuentes-por-facultad').parent().parent().hide().addClass('js-hidden-empty-view');
            }


            function addPlaceholder(input, placeholder) {
                $(input).attr('placeholder', placeholder);
            }

            // DESC: Desplega el menÃº lateral de Facultades
            // URL: /facultad/creacion-comunicacion
            function callMenuLateral(button, bodyClass) {
                $(document).on('click', button, function() {
                    $('body').toggleClass(bodyClass);
                });

                $(document).keyup(function(e) {
                    if (e.keyCode == 27) {
                        $('body').removeClass(bodyClass);
                    }
                });

				$(document).on('click', '.sidebar-overlay', function(e) {
					e.stopPropagation();
					$('body').removeClass(bodyClass);
				});

				$('.sidebar-content').click(function(e) {
					e.stopPropagation();
				});
            }

            // DESC: Pone el nombre de la Facultad como title del block
            // URL:
            function menuTitleMaker(field) {
                $('<li class="js-appended-menu-title menu-item">' + $(field).text() + '</li>')
                    .prependTo('.menu-modal .menu')
            }





            // BOOTSTRAP DEPENDANT SCRIPTS
            // Este carrusel se hace
            function carouselField() {
                $('.carousel-field .item').eq(0).addClass('active');
            }

            function makeCarouselSingle(item, idName, interval) {
                var interval = interval || 5000,
                    item = $(item);

                item
                    .addClass('item')
                    .wrapAll('<div id="' + idName + '" class="carousel slide" data-ride="carousel" data-interval="' + interval + '"><div class="carousel-inner" role="listbox"></div></div>');

                item.first().addClass('active');
            }

            function makeCarouselMultiple(items, idname, number, interval) {
                var interval = interval || 5000,
                    items = $(items);

                items
                    .wrapAll('<div id="' + idname + '" class="carousel slide" data-ride="carousel" data-interval="' + interval + '"><div class="carousel-inner" role="listbox"></div></div>');

                for (var i = 0; i < items.length; i += number) {
                    items.slice(i, i + number).wrapAll('<div class="item" />');
                }

                $('#' + idname + ' .item:eq(0)').addClass('active');
            }


            function makeCarouselButtons(element, idName) {
            	var btnLeft = $('<a class="left carousel-control" href="#' + idName + '" role="button" data-slide="prev"></a>'),
                	btnRight = $('<a class="right carousel-control" href="#' + idName + '" role="button" data-slide="next"></a>');

            		$('<div class="buttons-wrapper" />').appendTo(element);
            		btnLeft.appendTo('#' + idName + ' .buttons-wrapper');
            		btnRight.appendTo('#' + idName + ' .buttons-wrapper');
            }
			
			/*
            function makeCarouselButtons111(element, idName) {
                if (!$('.catalogo-editoriales').length) {
                    var btnLeft = $('<a class="left carousel-control" href="#' + idName + '" role="button" data-slide="prev"></a>'),
                        btnRight = $('<a class="right carousel-control" href="#' + idName + '" role="button" data-slide="next"></a>');

                    $('<div class="buttons-wrapper" />').appendTo(element);
                    btnLeft.appendTo('#' + idName + ' .buttons-wrapper');
                    btnRight.appendTo('#' + idName + ' .buttons-wrapper');
                } else {
                    var btnLeft = $('<a class="left carousel-control" href="#' + idName + '" role="button" data-slide="prev"></a>'),
                        btnRight = $('<a class="right carousel-control" href="#' + idName + '" role="button" data-slide="next"></a>');

                    $('<div class="buttons-wrapper" />').appendTo('.carousel');
                    btnLeft.appendTo('#' + idName + ' .buttons-wrapper');
                    btnRight.appendTo('#' + idName + ' .buttons-wrapper');
                }
            }*/

            // END BOOTSTRAP SCRIPTS

            function makeWow(elements) {
                $(elements).addClass('wow-section ' + wowAnimation);
            }

            // Tab de Especializaciones
            // URL: /programas-academicos, /posgrados
            function tabEspecializaciones(tabWrapper) {
                var viewsRow = $(tabWrapper + ' > .tabMakerContentInner > .views-row'),
                    selector0 = 'js-artes-diseno',
                    selector1 = 'js-ciencias-sociales',
                    selector2 = 'js-ingenierias-administracion',
                    selector3 = 'js-ciencias-naturales',
                    selector4 = 'js-interdisciplinarios',
                    columns = '<div class="js-column js-column-1"></div><div class="js-column js-column-2"></div><div class="js-column js-column-3 views-row"></div><div class="js-column js-column-4 views-row"></div>';

                viewsRow.eq(0).addClass(selector0);
                viewsRow.eq(1).addClass(selector1);
                viewsRow.eq(2).addClass(selector2);
                viewsRow.eq(3).addClass(selector3);
                viewsRow.eq(4).addClass(selector4);

                $('.' + selector3 + ' .views-row:lt(14)').addClass('item-col-2');
                $('.' + selector3 + ' .views-row:gt(13):lt(18)').addClass('item-col-3');
                $('.' + selector3 + ' .views-row:gt(31)').addClass('item-col-4');

                $('.item-col-2').wrapAll('<div class="js views-row belongs-to-col-2" />');
                $('.item-col-3').wrapAll('<div class="js views-row belongs-to-col-3" />');
                $('.item-col-4').wrapAll('<div class="js views-row belongs-to-col-4" />');


                $(columns).insertBefore('.' + selector0);
                $('.' + selector1).appendTo('.js-column-1');
                $('.' + selector4).appendTo('.js-column-1');
                $('.' + selector2).appendTo('.js-column-2');
                $('.' + selector3).appendTo('.js-column-2');

                $('.' + selector3 + ' > .views-field-label').clone().appendTo('.js-column-3');
                $('.' + selector3 + ' > .views-field-label').clone().appendTo('.js-column-4');
                $('.belongs-to-col-3').appendTo('.js-column-3');
                $('.belongs-to-col-4').appendTo('.js-column-4');
                $('.' + selector0).appendTo('.js-column-4');

                if (!$('.js-artes-diseno .view').children().length) {
                    $('.js-artes-diseno').hide();
                }

            }


            /*

            */
            function submenuMainMenu() {
                var submenuMainmenu = $('.submenu-mainmenu'),
                    body = $('body');
                submenuMainmenu.wrapAll('<div class="wrapper-submenus" />');

                var wrapperSubmenu = $('.wrapper-submenus');
                wrapperSubmenu.appendTo('#header');

                // Esto hace que el hover de los main menu despliegue los bloques de submenu
                function mainMenuHoverOverlay(item, block, className) {
                    var className = className || 'sub-menu-active';

                    $(item).parent().hover(
                        function() {
                            var context = $(this);
                            $('.content-sub-menu').not(item).stop().slideUp();
                            $(block).stop().slideDown();
                            body.addClass(className);
                        }
                    );


                    $('.base-overlay, .header_first, .header_second, .menu--menu-superior-home, .btn-digi, .btn-dire').mouseover(function() {
                        $(block).stop().slideUp();
                        body.removeClass(className);
                    });

                    // Este no tiene hijo
                    $('.menu-investigaciones').mouseover(function() {
                        $(block).stop().slideUp();
                        body.removeClass(className);
                    });
                }

                if ($(window).width() > tabletSize) {
                    mainMenuHoverOverlay('a.menu-inscripciones', 'div.menu-inscripciones', 'sub-menu-active ov-1');
                    mainMenuHoverOverlay('a.menu-programa-academico', 'div.menu-programa-academico', 'sub-menu-active ov-1');
                    mainMenuHoverOverlay('a.menu-nuestro-bosque', 'div.menu-nuestro-bosque', 'sub-menu-active ov-1');
                }



                mainMenuHoverOverlay('.header_info a.btn-facu', '.header_info .menu-faculty', 'sub-menu-active ov-2');
                mainMenuHoverOverlay('.header_info a.btn-idi', '.header_info .menu-translation', 'sub-menu-active ov-2');

                /*
                jQuery(".btn-facu").mouseenter(function(evento){
                   jQuery("#header").addClass("active-facultad");
                });
                jQuery(".btn-facu").mouseleave(function(evento){
                   jQuery("#header").removeClass("active-facultad");
                });*/
            }


            $('.file a, a[href*=".pdf"]').attr('target', '_blank');

            function externalLinks() {
                $('a[href*="http"]').each(function() {
                    var a = new RegExp('/' + window.location.host + '/');
                    if (!a.test(this.href)) {
                        $(this).click(function(event) {
                            event.preventDefault();
                            event.stopPropagation();
                            window.open(this.href, '_blank');
                        });
                    }
                });
            }

            /*
            	DESC: tabs verticales desplegables
            	@wrapper: div padre contenedor, sirve solo como referencia especÃ­fica
            	@parent: div padre del title y el tabContent, se presume que son varios, hijo de @wrapper
            	@tabContent: el div que deberÃ¡ de ser desplegable, hijo de @parent
            	@title: el div que deberÃ¡ ser clickeable para que @tabContent sea visible, hijo de @parent
            */
            function desplegableMaker(wrapper, parent, tabContent, title, activeClass, openFirst, level) {
                openFirst = openFirst || false;
                activeClass = activeClass || 'desplegable-open',
				level = level || false;

                var divWrapper = $(wrapper),
                    divTabContent = $(wrapper + ' ' + tabContent),
                    divTitle = $(wrapper + ' ' + title);

                //divTabContent.hide();

				if (level !== false) {
					divWrapper.addClass('desplegableMaker-wrapper-' + level);
					$(wrapper + ' ' + parent).addClass('desplegableMaker-parent-' + level);
					divTabContent.addClass('desplegableMaker-tabContent-' + level);
					divTitle.addClass('desplegableMaker-title-' + level);
				}
				
				

                if (openFirst === true) {
                    $(wrapper + ' ' + parent).eq(0).addClass(activeClass);
                    divTabContent.not(':eq(0)').hide();
                    divTabContent.eq(0).show(); // Por si ponen display none con CSS
                } else {
                    divTabContent.hide();
                }

                divTitle.attr('style', 'position: relative');
                $('<a class="arrow-toggle open-false ' + activeClass + '"><span></span></a><a class="arrow-toggle open-true ' + activeClass + '"><span></span></a>').appendTo(divTitle);


                var ifAnchor = $(wrapper + ' ' + title).is('a'),
                    clickeable = ifAnchor ? wrapper + ' ' + title + ' > .arrow-toggle' : wrapper + ' ' + title;

                //$(document).on('click', clickeable, function(e) {
                $(document).on('click', wrapper + ' ' + title, function(e) {
                    //if (ifAnchor) {
                    //	e.preventDefault();
                    //}
                    var context = $(this),
                        contextParent = context.parents(parent);

                    // Cerramos los demÃ¡s, pero abrimos el actual
                    contextParent.siblings().removeClass(activeClass).find(tabContent).slideUp();
                    contextParent.toggleClass(activeClass).find(tabContent).slideToggle();
                });
            }

            /*
            	DESC: hace tabs a partir del @tabContent
            	@wrapper: div padre contenedor, sirve solo como referencia especÃ­fica
            	@tabContent: div contenedor del contenido del tab, se presume que debe haber mÃ¡s de uno
            	@title: div del cual se extraerÃ¡ el texto para convertirlo en botÃ³n
            	@padding: usado por la funciÃ³n interna customLavalamp()
            */
            function tabMaker(wrapper, tabContent, title, padding) {
                var divWrapper = $(wrapper),
                    divTabContent = $(wrapper + ' ' + tabContent),
                    divTitle = $(wrapper + ' ' + title);

                // Creamos un div contenedor de los tab buttons
                $('<div class="tabMakerWrapper tabMakerWrapperNumChilds' + divTitle.length + '"><div class="tabMakerTabs"></div><div class="tabMakerContents"></div></div>').prependTo(wrapper);

                // A partir de los tÃ­tulos creamos los tabs
                divTitle.each(function() {
                    var context = $(this);

                    // Creamos los tabs para Desktop
                    $('<div class="tabMakerTab">' + context.html() + '<i></i></div>').appendTo($(wrapper + ' .tabMakerTabs'));
                });

                // A partir del tabContent creamos el contenido de los tabs
                divTabContent.each(function() {
                    var context = $(this);

                    $(wrapper + ' .tabMakerTab:eq()')

                    $('<div class="tabMakerContent" style="display: none"><div class="tabMakerContentInner">' + context.html() + '</div></div>')
                        .appendTo($(wrapper + ' .tabMakerContents'));
                    context.remove();
                });

                // Creamos los tabs versiÃ³n mobile
                $(wrapper + ' .tabMakerTab').each(function() {
                    var context = $(this);

                    // Creamos los tabs para Mobile, deja de ser tabs y se convierte en botones desplegables
                    $('<div class="tabMakerTabMobile" style="display: none">' + context.html() + '<div class="hovered">' + context.html() + '</div></div>')
                        .insertBefore(wrapper + ' .tabMakerContent:eq(' + context.index() + ') > .tabMakerContentInner');
                });


                // Hacemos la asociaciÃ³n con click entre los tabs creados y el contenido de ellos
                $(document).on('click', wrapper + ' .tabMakerTab', function(e, i) {
                    var context = $(this),
                        contextIndex = context.index();

                    $(wrapper + ' .tabMakerContent')
                        .eq(contextIndex)
                        //.addClass('front').removeClass('back')
                        .slideDown()
                        .siblings()
                        //.addClass('back').removeClass('front');
                        .slideUp();
                });

                // Hacemos que inicie visible siempre el primer tab
                $(wrapper + ' .tabMakerContent:eq(0)').show();

                // Usamos esta funciÃ³n para aplicar los activos dÃ¡ndoles efecto Lavalamp
                customLavalamp(wrapper + ' .tabMakerTabs', '.tabMakerTab', padding);

                // FunciÃ³n para que en mobile esto sea desplegable en vez de tabs
                $(document).on('click', wrapper + ' .tabMakerTabMobile', function() {
                    var context = $(this),
                        contextParent = context.parent('.tabMakerContent'),
                        contextIndex = contextParent.index(),
                        tabContent = $(wrapper + ' .tabMakerContent:eq(' + contextIndex + ')');

                    tabContent.toggleClass('active-mobile-tab').siblings().removeClass('active-mobile-tab');
                    tabContent.siblings().find('.tabMakerContentInner').slideUp();
                    tabContent.find('.tabMakerContentInner').slideToggle();
                });
            }

            if ($('.sidebar-first').length) {
                $('body').addClass('sidebar-first-present');
            }

            /*
            	@gap: margen left que compensa cuando el @button tiene padding-margin left
            */
            function customLavalamp(wrapper, button, gap) {
                var DivWrapper = $(wrapper),
                    DivButton = $(wrapper + ' ' + button),
                    className = 'lavalamp-active';

                // Hacemos que el primer button sea siempre active
                $(wrapper + ' ' + button).eq(0).addClass(className);

                $('<div class="lavalamp-bar"><i></i></div>').appendTo(DivWrapper);

                $(document).on('click', wrapper + ' ' + button, function() {
                    var context = $(this);

                    context
                        .addClass(className)
                        .siblings()
                        .removeClass(className);
                });

                function localMoveLavalamp(element) {
                    var buttonPosLeft = element.position().left,
                        buttonPosTop = element.position().top,
                        buttonWidth = element.outerWidth();
                    $(wrapper + ' ' + '.lavalamp-bar')
                        .css({ 'left': buttonPosLeft, 'width': buttonWidth, 'margin-left': gap });
                }

                // Movemos el lavalamp al primer activo
                localMoveLavalamp($(wrapper + ' ' + button).eq(0));

                $(window).resize(function() {
                    localMoveLavalamp($(wrapper + ' .' + className));
                });

                /*
                // Movemos el lavalamp al elemento en hover
                $(wrapper + ' ' + button).hover(
                	function() {
                		localMoveLavalamp($(this));
                	}
                );
                */
                $(document).on('click', wrapper + ' ' + button, function() {
                    localMoveLavalamp($(this));
                });
            }

            // URL: /inscripciones/
            if ($('.section-main-image + .block-webform')) {
                $('body').addClass('main-image-form');
            }

            // http://ubosque.seedlabs.co/facultad/creacion-comunicacion
            function facultadProgramaToggle() {
                var global = $('.carrera-toggle'),
                    btnPregrado = 'field--name-field-pregrado',
                    btnPosgrado = 'field--name-field-pos',
                    btns = '.field--name-field-pregrado, .field--name-field-pos',
                    pregrados = $('.field--name-field-programas-pregrado'),
                    posgrados = $('.field--name-field-programas-posgrado'),
                    generalbtns = $('.group-buttons'),
                    cerrar = '.carrera-toggle .close-cerrar';

                // Hace visible el div contenedor, y agrega una clase que indica que estÃ¡ visible
                function localToggle() {
                    global.toggleClass('opened').slideDown();
                }

                // Al elemento clickeado le agrega una clase y remueve la misma de los hermanos
                function localActiveClass(current) {
                    current.addClass('js-active').siblings().removeClass('js-active');
                }

                $(document).on('click', btns, function(element) {
                    element.preventDefault();
                    var context = $(this);
                    //generalbtns.css({'margin-bottom':'175px'});

                    // Si el div contenedor estÃ¡ invisible, hacerlo visible
                    if (global.is(':hidden')) {
                        localToggle();
                    }

                    // Si hago click al botÃ³n de Pregrado
                    if (context.hasClass(btnPregrado)) {
                        localActiveClass(context)
                        pregrados.show();
                        posgrados.hide();
                    }

                    // Si hago click al botÃ³n de Posgrado
                    if (context.hasClass(btnPosgrado)) {
                        localActiveClass(context);
                        pregrados.hide();
                        posgrados.show();
                    }
                })

                // BotÃ³n de cerrar
                $(document).on('click', cerrar, function() {
                    //localToggle();
                    global.removeClass('opened').slideUp();
                    $(btns).removeClass('js-active');
                    generalbtns.css({ 'margin-bottom': '0px' });
                });

                if (!pregrados.length) {
                    $('.group-buttons .field--name-field-pregrado').hide();
                }

                if (!posgrados.length) {
                    $('.group-buttons .field--name-field-pos').hide();
                }

            }

            function ajustarTextoDecano(responsiveInfo) {
                //	Si cambio de resoluciÃ³n 'Tablet' -> 'Mobile' Ã³ 'Desktop' -> 'Mobile'
                if (responsiveInfo.bnCambioTipoDeResolucion) {
                    //	Si paso a Mobile
                    if (responsiveInfo.tipoResolucion == 'Mobile') {
                        if ($('.titulo-para-mobile-facultad').length == 0) { $('<div></div>').addClass('titulo-para-mobile-facultad').prependTo('.block.decano-text .block-inner .block-content'); }

                        $('.block.decano-text .block-inner .block-content .text-content > .field.field--name-field-texto-inferior').clone().removeClass('onDesktop-NoMobile').appendTo('.titulo-para-mobile-facultad');
                        $('.block.decano-text .block-inner .block-content .text-content > .field.field--name-field-texto-superior').clone().removeClass('onDesktop-NoMobile').appendTo('.titulo-para-mobile-facultad');
                        $('.block.decano-text .block-inner .block-content .text-content > .field.field--name-field-correo-decano').clone().removeClass('onDesktop-NoMobile').appendTo('.titulo-para-mobile-facultad');
                    }
                    //	Si ya no esta en Mobile
                    else if (responsiveInfo.lastTipoResolucion == 'Mobile') {
                        $('.titulo-para-mobile-facultad').html('');
                    }
                }
            }

            function ajustarTextoDecanoAcercaDe(responsiveInfo) {
                //	Si cambio de resoluciÃ³n 'Tablet' -> 'Mobile' Ã³ 'Desktop' -> 'Mobile'
                if (responsiveInfo.bnCambioTipoDeResolucion) {
                    //	Si paso a Mobile
                    if (responsiveInfo.tipoResolucion == 'Mobile') {
                        if ($('.titulo-para-mobile-facultad').length == 0) { $('<div></div>').addClass('titulo-para-mobile-facultad').prependTo('.block-content--type-bloque-decano'); }

                        $('.block-content--type-bloque-decano .text-content .field--name-field-texto-superior').clone().removeClass('onDesktop-NoMobile').appendTo('.titulo-para-mobile-facultad');
                        $('.block-content--type-bloque-decano .text-content .field--name-field-correo-decano').clone().removeClass('onDesktop-NoMobile').appendTo('.titulo-para-mobile-facultad');
                    }
                    //	Si ya no esta en Mobile
                    else if (responsiveInfo.lastTipoResolucion == 'Mobile') {
                        $('.titulo-para-mobile-facultad').html('');
                    }
                }
            }

            function facultadCambiarDeLugaBannerEnTablet() {
                if (window.bnAjustarFacultadResponsive === undefined) {
                    if ($('body').hasClass('page-faculties')) {
                        $('.block.block-system.block-system-main-block').clone().addClass('onTablet').insertBefore(".wrap-content > .layout-content");
                        $('.block.block-system.block-system-main-block:not(.onTablet)').addClass('onDesktop-NoTablet');

                        $('.block.decano-text .block-inner .block-content .text-content > .field.field--name-field-texto-inferior').addClass('onDesktop-NoMobile');
                        $('.block.decano-text .block-inner .block-content .text-content > .field.field--name-field-texto-superior').addClass('onDesktop-NoMobile');
                        $('.block.decano-text .block-inner .block-content .text-content > .field.field--name-field-correo-decano').addClass('onDesktop-NoMobile');

                        Responsive.addFunctionToExecuteOnResize(ajustarTextoDecano, true);
                    } else if ($('body').hasClass('page-node-type-acerca-de-la-facultad')) {
                        $('.block-content--type-bloque-decano .text-content .field--name-field-texto-superior').addClass('onDesktop-NoMobile');
                        $('.block-content--type-bloque-decano .text-content .field--name-field-correo-decano').addClass('onDesktop-NoMobile');

                        Responsive.addFunctionToExecuteOnResize(ajustarTextoDecanoAcercaDe, true);
                    }

                    //	ajustarTextoDecano: AÃ±ade la funciÃ³n a una lista que se ejecutara cuando cambie la resoluciÃ³n(enviandole parametros necesarios),
                    //	true: ejecutar inmediatamente la funciÃ³n sin necesidad de que cambie resoluciÃ³n

                    window.bnAjustarFacultadResponsive = true;
                }
            };
            facultadCambiarDeLugaBannerEnTablet();

            
			if (!$('.page-infraestructura').length) {
				quickFakeSelect();
			}

            function quickFakeSelect() {

                $(document).on('click', '.fake-select', function() {
                    var
                        context = $(this),
                        others = $('.fake-select').not(context);

                    others.find('.ul-wrapper').slideUp();
                    others.find('.fake-selected').removeClass('open');
                });

                $(document).on('click', '.fake-select li', function() {
                    var context = $(this);
                    context.parent().parent().parent().prev().find('.f div').text(context.text());
                    context.addClass('active').siblings().removeClass('active');
                    context.parents('.ul-wrapper').slideUp();
                });

                $(document).on('click', '.fake-selected', function() {
                    var context = $(this);
                    context.toggleClass('open');
                    context.next().slideToggle();
                });
            }

            function colocarADosLineas(valor) {
                var numLineasAColocar = ((valor.length) / 2)
                var sumNumLineasAColocar = 0;
                var arPalabrasValor = valor.split(' ');
                var nuevoValor = '';
                var bnYaSeColocoUnBr = false;

                bnPrimeraPalabra = true;
                for (var count = 0; count < arPalabrasValor.length; count++) {
                    numPalabra = count + 1;
                    palabra = arPalabrasValor[count];
                    sumNumLineasAColocar += palabra.length;

                    if (!bnPrimeraPalabra) {
                        if (numLineasAColocar < sumNumLineasAColocar && !bnYaSeColocoUnBr) {
                            nuevoValor = nuevoValor + '<br>';
                            bnYaSeColocoUnBr = true;
                        } else {
                            nuevoValor = nuevoValor + ' ';
                        }
                    }

                    nuevoValor = nuevoValor + palabra;

                    bnPrimeraPalabra = false;
                }
                return nuevoValor;
            }

            function quitarDosLineas(valor) {
                return valor.replace('<br>', ' ');
            }

            window.bnAjustadoProgramasComplementariosEnTablet = false;

            function ajustarProgramasComplementariosEnTablet(responsiveInfo) {
                if (responsiveInfo.tipoResolucion == 'Mobile' || responsiveInfo.tipoResolucion == 'Tablet') {
                    if (!window.bnAjustadoProgramasComplementariosEnTablet) {
                        $('.block.block-block-contentf1334d11-dbbd-41ce-a0ca-847ce83f75d9 .field--name-field-links a').each(function() {
                            $(this).html(colocarADosLineas($(this).html()));
                        });
                        window.bnAjustadoProgramasComplementariosEnTablet = true;
                    }
                } else if (responsiveInfo.tipoResolucion == 'Desktop') {
                    if (window.bnAjustadoProgramasComplementariosEnTablet) {
                        $('.block.block-block-contentf1334d11-dbbd-41ce-a0ca-847ce83f75d9 .field--name-field-links a').each(function() {
                            $(this).html(quitarDosLineas($(this).html()));
                        });
                        window.bnAjustadoProgramasComplementariosEnTablet = false;
                    }
                }
            }
            if (window.bnAjustarProgramasComplementariosEnTablet === undefined) {
                Responsive.addFunctionToExecuteOnResize(ajustarProgramasComplementariosEnTablet, true);
                window.bnAjustarProgramasComplementariosEnTablet = true;
            }



            if ($('.page-faculties').length) {
                facultadProgramaToggle();
            }

            // URL: /directorio/academicos
            if ($('.menu--menu-directorios')) {
                $('.menu--menu-directorios .form-select').before($('.menu--menu-directorios .js-form-type-select > label'));
            }
            //URL: /directorio/academicos
            if ($('.views-field-field-detalle-academico')) {
                $(".views-field-field-detalle-academico > .field-content").addClass('field-content-detalle');
            }

        }
    }


})(jQuery, Drupal, this, this.document);

(function($) {

    jQuery(window).load(function() {
        //Publicidad mobile
        var publicidad = jQuery('.block-views-blockpublicidad-block-1').clone(true);
        jQuery('.layout-content--post-content').prepend(publicidad);
        //Initialize 	
        var swiper = new Swiper('.block-views-blockpublicidad-block-1 .swiper-container', {
            autoplay: 7000
        });

        // URL: /bienestar-universitario/
        var swiper = new Swiper('.view-agenda-bienestar-universitario .swiper-container', {
            autoplay: 7000,
            slidesPerView: 4,
            spaceBetween: 47,
            breakpoints: {
                560: {
                    slidesPerView: 1,
                    spaceBetween: 30
                },
                990: {
                    slidesPerView: 2,
                    spaceBetween: 30
                }
            }
        });

		
		if ($('#header .block-views-exposed-filter-blockprueba-page-1').length) {
	        var search = jQuery('#header .block-views-exposed-filter-blockprueba-page-1 .form-text').val();
	        if (search.length == 0 && jQuery('.path-busca').length) {
	            search = getUrlParameter('keys');
	            jQuery('.path-busca .js-form-item-keys .form-text').val(search);
	        }

	        $('<div class="search-results-keyword"><strong>' + search + '"</strong></div>')
	            .prependTo(jQuery(".path-busca .layout-content"));
	        jQuery(".view-prueba .view-header").clone().prependTo(jQuery(".path-busca .layout-content"));

	        jQuery(".path-busca .layout-content .view-header").removeClass("view-header").addClass("search-results-size");

	        jQuery(".block-views-exposed-filter-blockprueba-page-1").clone().prependTo(jQuery(".path-busca .wrap-content"));
	        jQuery(".path-busca .wrap-content .block-views-exposed-filter-blockprueba-page-1").removeClass('search-block-form block-search').addClass("search-view-results");
	        jQuery(".search-view-results #views-exposed-form-prueba-page-1").removeAttr('id');
	        jQuery('.path-busca #header .block-views-exposed-filter-blockprueba-page-1 .js-form-submit').click();

	        //var result = jQuery('.path-busca .view-header').val();
	        //$('<div class="keyword">' + search + '</div>').prependTo(jQuery(".path-busca .content.region-content"));

	        //$('.keyword').appendTo('.view-prueba .view-header');
	        //$('<div class="result">' + result + '</div>').prependTo(jQuery(".path-busca .content"));
	        jQuery('.block-views-exposed-filter-blockprueba-page-1 .form-text').val('');
	        jQuery('.path-busca .header_second .block-views-exposed-filter-blockprueba-page-1 .form-text').val('');
	        //Es necesario remover la clase dado que en la interna de las bÃºsquedas se invierte el proceso de la 'X'
	        jQuery('.path-busca .close-search').removeClass('display-close-search');
		}
		
        //URL: /nuestro-bosque/catalogo/
        jQuery('.catalogo-editoriales').each(function(){
            var afterItem = jQuery(this).find('.carousel-inner')
            jQuery(this).find('.buttons-wrapper').first().insertAfter(afterItem);
        })

        //URL: directorio/facultades
        jQuery('.path-directorio .view-directorio-facultad .view-content > .view-grouping').each(function(){
            var groupCont = jQuery(this).find('> .view-grouping-content');
                innerGrp = jQuery(this).find('> .view-grouping-content .view-grouping > .view-grouping-content h3');
            jQuery(this).find('> .view-grouping-header ').insertAfter(groupCont)
            jQuery(this).find('> .view-grouping-content .view-grouping > .view-grouping-header').insertAfter(innerGrp);
        }) 

           
        // addPlaceholder(".page-form-bosque-te-acoge .field--name-title .form-text", "Nombre:");
        

    });

	if ($('#header .block-views-exposed-filter-blockprueba-page-1').length) {
	    if (jQuery('#header .block-views-exposed-filter-blockprueba-page-1 .form-text').val().length > 0) {
	        jQuery('#header .block-views-exposed-filter-blockprueba-page-1 .form-text').toggleClass('active')
	    }
	}


    // jQuery('#header .block-views-exposed-filter-blockprueba-page-1 .js-form-submit').click(function(e) {
    //   var contenidobuscador = jQuery('#header .block-views-exposed-filter-blockprueba-page-1 .form-text').val().length;
    //   console.log(contenidobuscador);
    //   if (contenidobuscador > 0) {
    //     	return true;
    //   }
    //   else {
    //     e.preventDefault();
    //     //jQuery('body').toggleClass('ensayo');
    //     jQuery('#header .block-views-exposed-filter-blockprueba-page-1 .form-text').toggleClass('expanded');
    //     return false;
    //   }
    // });

    //Cambiar texto links
    //URL: /centro-informacion/convocatorias
    if ($('.detail-convocatoria')) {
        $('.views-button .views-infinite-scroll-content-wrapper .field--name-node-link a').text('ver detalle convocatoria');
    }

    //Cambiar texto boton
    //Catalogo de publicaciones busqueda
    if ($('.block-views-exposed-filter-blockcatalogo-de-publicaciones-page-1')) {
        $('.block-views-exposed-filter-blockcatalogo-de-publicaciones-page-1 .button').val('Filtrar');
    }

    //Cambiar texto link
    //URL: /audiencia/aspirantes
    if ($('.blog-wordpress')) {
        $('.blog-wordpress .field--type-uri a').text('Ver mÃ¡s');
    }

    //Cortar texto de fecha

    if ($('.block-views-blockcatalogo-memorias-block-1')) {
        $(".block-views-blockcatalogo-memorias-block-1 .field--name-field-fecha-inicio-inscripcion").each(function(index) {
            $(this).text($(this).text().split("/")[2]);
        });
        //console.log($('.block-views-blockcatalogo-memorias-block-1 .field--name-field-fecha-inicio-inscripcion').text());
        //$('.block-views-blockcatalogo-memorias-block-1 .field--name-field-fecha-inicio-inscripcion').text($('.block-views-blockcatalogo-memorias-block-1 .field--name-field-fecha-inicio-inscripcion').text().split("/")[2]);
    }

    //jQuery('.block-views-exposed-filter-blockprueba-page-1 .form-text').val('');
    $(".block-views-exposed-filter-blockprueba-page-1 .form-text").attr("placeholder", "Ingresa los tÃ©rminos de bÃºsqueda aquÃ­");
    $(".post_content .block-search .form-search").attr("placeholder", "Ej.: Programa de DiseÃ±o y ComunicaciÃ³n");
    $(".views-exposed-form .form-item-title .form-text, .views-exposed-form .form-item-search-api-fulltext .form-text").attr("placeholder", "Buscar");
    
	//Buscador
	if ($('.header_second .block-search').length) {
	    if (jQuery('.header_second .block-search .form-text').val().length > 0) {
	        jQuery('.header_second .block-search .form-text').toggleClass('active');
	    }
	}

    //CatÃ¡logo publicaciones
    jQuery('.view-catalogo-de-publicaciones .views-row').each(function(index) {
       if((index + 1) % 4 == 0) {
        jQuery('<div class="clearfix"></div>').insertAfter(this)
       }
    });

    

    //Boton cerrar buscar:
    /*jQuery('#header .close-search').click(function(e){
    	jQuery('.header_second .block-views-exposed-filter-blockprueba-page-1').toggleClass('expanded');
    	jQuery('body').toggleClass('active-search');
    	jQuery('body, #header').toggleClass('active-search');
    	jQuery('body .container--header-info').toggleClass('active-search-2');
    	jQuery('#header .display-close-search').removeClass('display-close-search');
    });*/

    $('<div class="js-append-text">InformaciÃ³n para:</div>').prependTo('.container--header-info .menu--menu-superior-home .menu-item:nth-child(1)')

    jQuery('#header .close-search').click(function(e) {
        var contenidobuscador = jQuery('.block-search .form-text').val().length;
        jQuery('#header .close-search').toggleClass('display-close-search');
        if (contenidobuscador > 0) {
            return true;
        } else {
            e.preventDefault();
            jQuery('body, #header').toggleClass('active-search');
            jQuery('body .container--header-info').toggleClass('active-search-2');
            jQuery('.header_second .search-block-form').toggleClass('expanded');
        }
    });

    //URL /directorio/academicos
    //Desplegables
    jQuery('.views-label-field-detalle-academico').click(function() {
        if (globalFlag_directory == 0 || globalFlag_directory % 2 == 0) {
            if ($(this).hasClass("open-desplegable")) {
                $(this).parent().find('.field-content-detalle').slideUp();
            } else {
                $(this).parent().find('.field-content-detalle').slideDown();
            }
            $(this).toggleClass("open-desplegable");
        }
        globalFlag_directory++;
    })

    //URL: /directorio/academicos
    jQuery('.form-item-field-facultades-personal-target-id .form-select, .form-item-field-programa-academico-target-id .form-select').change(function(e) {
        $("#edit-submit-directorio-academico").trigger("click");
    })

    jQuery('.header_second .block-search .button').click(function(e) {
        var contenidobuscador = jQuery('.block-search .form-text').val().length;
        jQuery('#header .close-search').toggleClass('display-close-search');
        if (contenidobuscador > 0) {
            if (globalFlag > 0) {
                var flag = jQuery('.path-busca .header_second .block-views-exposed-filter-blockprueba-page-1 .form-text').val();
                jQuery('body, #header').toggleClass('active-search');
                jQuery('body .container--header-info').toggleClass('active-search-2');
                jQuery('.header_second .search-block-form').toggleClass('expanded');
                jQuery(".path-busca .layout-content .search-results-keyword").text(flag);
                jQuery(".path-busca .layout-content .search-results-size")
                    .text(($(".path-busca .layout-content .search-results-size")).substring(2, ((jQuery(".path-busca .layout-content .search-results-size")).length)));
            }
            globalFlag++;
            return true;
        } else {
            e.preventDefault();
            jQuery('body, #header').toggleClass('active-search');
            jQuery('body .container--header-info').toggleClass('active-search-2');
            jQuery('.header_second .search-block-form').toggleClass('expanded');
        }
    });

    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    };

    $.fn.liveFilter = function(inputEl, filterEl, options) {
        var defaults = {
            filterChildSelector: null,
            filter: function(el, val) {
                return $(el).text().toUpperCase().indexOf(val.toUpperCase()) >= 0;
            },
            before: function() {},
            after: function() {}
        };
        var options = $.extend(defaults, options);

        var el = $(this).find(filterEl);
        if (options.filterChildSelector) el = el.find(options.filterChildSelector);

        var filter = options.filter;
        $(inputEl).keyup(function() {
            var val = $(this).val();
            var contains = el.filter(function() {
                return filter(this, val);
            });
            var containsNot = el.not(contains);
            if (options.filterChildSelector) {
                contains = contains.parents(filterEl);
                containsNot = containsNot.parents(filterEl).hide();
            }

            options.before.call(this, contains, containsNot);

            containsNot.hide();

            contains.each(function(e) {
                if (e <= 2) {
                    contains.eq(e).show();
                }
            });

            if (val === '') {
                contains.hide();
                containsNot.hide();
            }

            if (val.length == 0) {
                $('.all-programs').addClass('element-hidden');
            } else {
                $('.all-programs').removeClass('element-hidden');
            }

            if (contains.length == 0 && val.length > 0) {
                $('.no-results').removeClass('element-hidden');
            } else {
                $('.no-results').addClass('element-hidden');
            }

            options.after.call(this, contains, containsNot);
        });
    }

    $('.programs-list').liveFilter('.block-views-blockprogramas-academicos-block-1 .view-filters .form-text', 'li', {
        filterChildSelector: 'a'
    });
    //se crea elemento para mostrar cuando no hay resultados en la bÃºsqueda
    $('<div class="no-results element-hidden">No se encontraron resultados</div>').appendTo('.programs-list');
    $('<div class="all-programs element-hidden"><a class="btn-green-l" href="/programas-academicos">Todos los programas</a></div>').appendTo('.programs-list');

    //se deshabilita el autocomplete del navegador en el bÃºscador de programas
    jQuery(".banner-search .form-text").attr("autocomplete", "off");


    //se personalizan las etiquetas con base en Maestria/Especializacion/Doctorado/Pregrado
    if ($('body').hasClass("grouptype-maestria")) {
        jQuery('.acerca-de span').text("Acerca de la MaestrÃ­a En");
        jQuery('.field--name-dynamic-token-fieldgroup-pregrado-boton-back div').text("MaestrÃ­a En");
    }
    if ($('body').hasClass("grouptype-doctorados")) {
        jQuery('.acerca-de span').text("Acerca del Doctorado En");
        jQuery('.field--name-dynamic-token-fieldgroup-pregrado-boton-back div').text("Doctorado En");
    }
    if ($('body').hasClass("grouptype-especializacion")) {
        jQuery('.acerca-de span').text("Acerca de la EspecializaciÃ³n En");
        jQuery('.field--name-dynamic-token-fieldgroup-pregrado-boton-back div').text("EspecializaciÃ³n En");
    }

    //Enlaces dinÃ¡micos de los programas hacia cada facultad
    if (($('body').hasClass("grouptype-maestria")) || ($('body').hasClass("grouptype-doctorados")) || ($('body').hasClass("grouptype-especializacion")) || ($('body').hasClass("grouptype-pregrados"))) {
        if ($('body').hasClass('page-facultad-de-creacion-y-comunicacion')) {
            jQuery('.field--name-dynamic-token-fieldgroup-pregrado-boton-back p').text("Facultad de CreaciÃ³n y ComunicaciÃ³n");
            jQuery('.field--name-dynamic-token-fieldgroup-pregrado-boton-back p').wrap("<a href='/creacion-y-comunicacion'></a>");
        }
        if ($('body').hasClass('page-facultad-de-ciencias')) {
            jQuery('.field--name-dynamic-token-fieldgroup-pregrado-boton-back p').text("Facultad de Ciencias");
            jQuery('.field--name-dynamic-token-fieldgroup-pregrado-boton-back p').wrap("<a href='/ciencias'></a>");
        }
        if ($('body').hasClass('page-facultad-de-ciencias-economicas-y-administrativas')) {
            jQuery('.field--name-dynamic-token-fieldgroup-pregrado-boton-back p').text("Facultad de Ciencias EconÃ³micas y Administrativas");
            jQuery('.field--name-dynamic-token-fieldgroup-pregrado-boton-back p').wrap("<a href='/ciencias-economicas-y-administrativas'></a>");
        }
        if ($('body').hasClass('page-facultad-de-ciencias-politicas-y-juridicas')) {
            jQuery('.field--name-dynamic-token-fieldgroup-pregrado-boton-back p').text("Facultad de Ciencias PolÃ­ticas y JurÃ­dicas");
            jQuery('.field--name-dynamic-token-fieldgroup-pregrado-boton-back p').wrap("<a href='/ciencias-politicas-y-juridicas'></a>");
        }
        if ($('body').hasClass('page-facultad-de-educacion')) {
            jQuery('.field--name-dynamic-token-fieldgroup-pregrado-boton-back p').text("Facultad de EducaciÃ³n");
            jQuery('.field--name-dynamic-token-fieldgroup-pregrado-boton-back p').wrap("<a href='/educacion'></a>");
        }
        if ($('body').hasClass('page-facultad-de-enfermeria')) {
            jQuery('.field--name-dynamic-token-fieldgroup-pregrado-boton-back p').text("Facultad de EnfermerÃ­a");
            jQuery('.field--name-dynamic-token-fieldgroup-pregrado-boton-back p').wrap("<a href='/enfermeria'></a>");
        }
        if ($('body').hasClass('page-facultad-de-ingenieria')) {
            jQuery('.field--name-dynamic-token-fieldgroup-pregrado-boton-back p').text("Facultad de IngenierÃ­a");
            jQuery('.field--name-dynamic-token-fieldgroup-pregrado-boton-back p').wrap("<a href='/ingenieria'></a>");
        }
        if ($('body').hasClass('page-facultad-de-medicina')) {
            jQuery('.field--name-dynamic-token-fieldgroup-pregrado-boton-back p').text("Facultad de Medicina");
            jQuery('.field--name-dynamic-token-fieldgroup-pregrado-boton-back p').wrap("<a href='/medicina'></a>");
        }
        if ($('body').hasClass('page-facultad-de-odontologia')) {
            jQuery('.field--name-dynamic-token-fieldgroup-pregrado-boton-back p').text("Facultad de OdontologÃ­a");
            jQuery('.field--name-dynamic-token-fieldgroup-pregrado-boton-back p').wrap("<a href='/odontologia'></a>");
        }
        if ($('body').hasClass('page-facultad-de-psicologia')) {
            jQuery('.field--name-dynamic-token-fieldgroup-pregrado-boton-back p').text("Facultad de PsicologÃ­a");
            jQuery('.field--name-dynamic-token-fieldgroup-pregrado-boton-back p').wrap("<a href='/psicologia'></a>");
        }
        if ($('body').hasClass('page-departamento-de-humanidades')) {
            jQuery('.field--name-dynamic-token-fieldgroup-pregrado-boton-back p').text("Departamento de Humanidades");
            jQuery('.field--name-dynamic-token-fieldgroup-pregrado-boton-back p').wrap("<a href='/humanidades'></a>");
        }
    }

    //Enlaces dinÃ¡micos de los productos acadÃ©micos de cada facultad
    if ($('body').hasClass("grouptype-facultades")) {
        if ($('body').hasClass('page-facultad-de-creacion-y-comunicacion')) {
            jQuery('.product-basic-feature-content-large .field--name-field-grupos-facultades- a').text("Facultad de CreaciÃ³n y ComunicaciÃ³n");
            jQuery('.product-basic-feature-content-large .field--name-field-grupos-facultades- a').attr("href", "/creacion-y-comunicacion");
            jQuery('.product-basic-feature-content-large .field--name-field-enlace a').attr("href", "/creacion-y-comunicacion/producto-academico");
        }
        if ($('body').hasClass('page-facultad-de-ciencias')) {
            jQuery('.product-basic-feature-content-large .field--name-field-grupos-facultades- a').text("Facultad de Ciencias");
            jQuery('.product-basic-feature-content-large .field--name-field-grupos-facultades- a').attr("href", "/ciencias");
            jQuery('.product-basic-feature-content-large .field--name-field-enlace a').attr("href", "/ciencias/producto-academico");
        }
        if ($('body').hasClass('page-facultad-de-ciencias-economicas-y-administrativas')) {
            jQuery('.product-basic-feature-content-large .field--name-field-grupos-facultades- a').text("Facultad de Ciencias EconÃ³micas y Administrativas");
            jQuery('.product-basic-feature-content-large .field--name-field-grupos-facultades- a').attr("href", "/ciencias-economicas-y-administrativas");
            jQuery('.product-basic-feature-content-large .field--name-field-enlace a').attr("href", "/ciencias-economicas-y-administrativas/producto-academico");
        }
        if ($('body').hasClass('page-facultad-de-ciencias-politicas-y-juridicas')) {
            jQuery('.product-basic-feature-content-large .field--name-field-grupos-facultades- a').text("Facultad de Ciencias PolÃ­ticas y JurÃ­dicas");
            jQuery('.product-basic-feature-content-large .field--name-field-grupos-facultades- a').attr("href", "/ciencias-politicas-y-juridicas");
            jQuery('.product-basic-feature-content-large .field--name-field-enlace a').attr("href", "/ciencias-politicas-y-juridicas/producto-academico");
        }
        if ($('body').hasClass('page-facultad-de-educacion')) {
            jQuery('.product-basic-feature-content-large .field--name-field-grupos-facultades- a').text("Facultad de EducaciÃ³n");
            jQuery('.product-basic-feature-content-large .field--name-field-grupos-facultades- a').attr("href", "/educacion");
            jQuery('.product-basic-feature-content-large .field--name-field-enlace a').attr("href", "/educacion/producto-academico");
        }
        if ($('body').hasClass('page-facultad-de-enfermeria')) {
            jQuery('.product-basic-feature-content-large .field--name-field-grupos-facultades- a').text("Facultad de EnfermerÃ­a");
            jQuery('.product-basic-feature-content-large .field--name-field-grupos-facultades- a').attr("href", "/enfermeria");
            jQuery('.product-basic-feature-content-large .field--name-field-enlace a').attr("href", "/enfermeria/producto-academico");
        }
        if ($('body').hasClass('page-facultad-de-ingenieria')) {
            jQuery('.product-basic-feature-content-large .field--name-field-grupos-facultades- a').text("Facultad de IngenierÃ­a");
            jQuery('.product-basic-feature-content-large .field--name-field-grupos-facultades- a').attr("href", "/ingenieria");
            jQuery('.product-basic-feature-content-large .field--name-field-enlace a').attr("href", "/ingenieria/producto-academico");
        }
        if ($('body').hasClass('page-facultad-de-medicina')) {
            jQuery('.product-basic-feature-content-large .field--name-field-grupos-facultades- a').text("Facultad de Medicina");
            jQuery('.product-basic-feature-content-large .field--name-field-grupos-facultades- a').attr("href", "/medicina");
            jQuery('.product-basic-feature-content-large .field--name-field-enlace a').attr("href", "/medicina/producto-academico");
        }
        if ($('body').hasClass('page-facultad-de-odontologia')) {
            jQuery('.product-basic-feature-content-large .field--name-field-grupos-facultades- a').text("Facultad de OdontologÃ­a");
            jQuery('.product-basic-feature-content-large .field--name-field-grupos-facultades- a').attr("href", "/odontologia");
            jQuery('.product-basic-feature-content-large .field--name-field-enlace a').attr("href", "/odontologia/producto-academico");
        }
        if ($('body').hasClass('page-facultad-de-psicologia')) {
            jQuery('.product-basic-feature-content-large .field--name-field-grupos-facultades- a').text("Facultad de PsicologÃ­a");
            jQuery('.product-basic-feature-content-large .field--name-field-grupos-facultades- a').attr("href", "/psicologia");
            jQuery('.product-basic-feature-content-large .field--name-field-enlace a').attr("href", "/psicologia/producto-academico");
        }
        if ($('body').hasClass('page-departamento-de-humanidades')) {
            jQuery('.product-basic-feature-content-large .field--name-field-grupos-facultades- a').text("Departamento de Humanidades");
            jQuery('.product-basic-feature-content-large .field--name-field-grupos-facultades- a').attr("href", "/humanidades");
            jQuery('.product-basic-feature-content-large .field--name-field-enlace a').attr("href", "/humanidades/producto-academico");
        }
    }

    // Sub menu

    /*
      jQuery('.menu--menu-principal .menu-item a').mouseover(function(e){
        var elemenHover = jQuery(this).context.classList[0];
        jQuery('body').addClass('sub-menu-active');
        jQuery('.content-sub-menu.' + elemenHover).addClass('active');
      })

      jQuery('.menu--menu-principal .menu-item a').mouseout(function(e) {
        var elemenHover = jQuery(this).context.classList[0];
        jQuery('body').removeClass('sub-menu-active');
        jQuery('.content-sub-menu.' + elemenHover).removeClass('active');
      });



      jQuery('.content-sub-menu').mouseover(function() {
        jQuery('body').addClass('sub-menu-active');
        jQuery(this).addClass('active');
      })

      jQuery('.content-sub-menu').mouseout(function() {
        jQuery('body').removeClass('sub-menu-active');
        jQuery(this).removeClass('active');
      })

      //Sub Menu info
      jQuery('.menu--menu-superior-home .menu-item a').mouseover(function(e){
        var elemenHover = jQuery(this).context.classList[0];
        jQuery('body').addClass('sub-menu-active');
        jQuery('.content-sub-menu.' + elemenHover).addClass('active');
      })

      jQuery('.menu--menu-superior-home .menu-item a').mouseout(function(e) {
        var elemenHover = jQuery(this).context.classList[0];
        jQuery('body').removeClass('sub-menu-active');
        jQuery('.content-sub-menu.' + elemenHover).removeClass('active');
      });


    */

    //buscador productos acadÃ©micos
    jQuery('.academic-program-custom-search .form-submit')
        .clone()
        .appendTo(jQuery('.page-node-type-pagina-productos-academicos .paragraphs_large'))
        .wrap('<div class="js-tag-academic-product"><div class="inner"></div></div>');
    jQuery('.page-node-type-pagina-productos-academicos .paragraphs_large .form-submit').val("Todas");
    jQuery('.page-node-type-pagina-productos-academicos .paragraphs_large .form-submit').click(function(e) {
        if ($('.academic-program-custom-search .form-text').val() != "") {
            $('.academic-program-custom-search .form-text').val("");
            $(".academic-program-custom-search .form-submit").trigger("click");
            $(".paragraphs_large select").val("All");
        }
    });

    jQuery('.academic-program-custom-search .form-select')
        .clone()
        .appendTo(jQuery('.page-node-type-pagina-productos-academicos .paragraphs_large'))
        .wrap('<div class="js-tag-academic-product-select"><div class="inner"></div></div>');
    jQuery('.academic-program-custom-search .form-select').addClass('element-hidden');
    jQuery('.academic-program-custom-search .form-submit').addClass('element-hidden');
    jQuery('.page-node-type-pagina-productos-academicos .paragraphs_large .form-select').change(function() {
        var programa = jQuery('.page-node-type-pagina-productos-academicos .paragraphs_large .form-select option:selected').text();
        $('.academic-program-custom-search .form-text').val(programa);
        $(".academic-program-custom-search .form-submit").trigger("click");
    });
    // Etiquetas
    $('<div class="js-label">Consultar:</div>').insertBefore('.js-tag-academic-product .inner');
    $('<div class="js-label">Programa acadÃ©mico:</div>').insertBefore('.js-tag-academic-product-select .inner');
    //Hora en eventos
    jQuery('.page-node-type-eventos .node--type-eventos .node-date .item-hour').detach().appendTo('.page-node-type-eventos .node--type-eventos .node-date');

    //Cambio fecha formato
    function changeDate(str) {
        $(str).each(function() {
            var dateArray = $(this).text().split(' ');
            $(this).append('<div class="date-js"> <span class="date-month">' + dateArray[0] + '</span>' + '<span class="date-day">' + dateArray[1] + '</span> </div>');
        });
    }
    changeDate($('.page-node-type-pagina-basica-bosque.page-internacionalizacion .block.acordeon-becas-inter .bar-desplegable-content .field--name-field-fecha-inicio .field__item'));
    changeDate($('.page-node-type-pagina-basica-bosque.page-internacionalizacion .block.acordeon-becas-inter .bar-desplegable-content .field--name-field-fecha-limite .field__item'))

    // centro de lenguas home requisitos
    $('.centro-lenguas-home .region-section-1 .field--name-field-pre-title').click(function() {
        var selectElementPatent = $(this).parents('.block-block-content');
        selectElementPatent.addClass('active');
        selectElementPatent.siblings('.block-block-content').removeClass('active');
    });
    var widthWindow = jQuery(window).width();
    if(widthWindow < 400 ){
        jQuery('.centro-lenguas-home .region-section-1 .region-content .inscripciones-block ').removeClass('active');
    }

    // Form centro de lenguas home
    $('.centro-lenguas-home select#edit-estoy-interesado-en-').change(function() {
        var valueSelect = $(this).val();
        if (valueSelect == 'Otro') {
            $('.centro-lenguas-home .block-webform .form-item-escribe-algo-').addClass('active');
        } else {
            $('.centro-lenguas-home .block-webform .form-item-escribe-algo-').removeClass('active');
        }
    });

    // Tablas centro lenguas
    $('.tabla-cursos-lenguas').each(function(x, y) {
        var clasList = this.classList[2];
        var arrayClass = clasList.split('-');
        if (arrayClass.slice(-1)[0] != 'block') {
            $(this).find('#tablefield-wrapper-' + arrayClass.slice(-1)[0]).addClass('tabla-mobile')
        }
    });
    $('.tablefield-wrapper').addClass('table-ready');

    // Home bienestar universitario
    $(function() {
        $('.view-agenda-bienestar-universitario .view-footer a').on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({ scrollTop: $($('.home-bienestar-universitario .region-section-4')).offset().top}, 500, 'linear');
        });
    });

    //URL: talento-humano/gestion
    $('.gestion-talento .content-table-gestion-talento .field__item').shorten({
        moreText: 'Ver mÃ¡s',
        lessText: 'Ver menos',
        ellipsesText: '...',
        showChars: 280 //260
    }); 

    //Previene acciÃ³n del item de lenguaje
    $('.menu--menu-superior-home-derecho .btn-idi').click(function(e) {
        e.preventDefault();
    }) 

    //URL: investigaciones/nuestro-equipo
    $('.page-investigaciones .menu--investigaciones .menu-item:nth-child(5) a').click(function(e){
        e.preventDefault();
        $('.page-investigaciones .menu--investigaciones .menu-item:nth-child(n+6):nth-child(-n+12)').fadeToggle('slow');
    })
	
	// Insertamos un <br> antes de cada .edu.co para mobile
	$('.view-nuestro-equipo.view-display-id-block_1 .field--name-field-correo a').each(function() {
		var context = $(this);
		
		context.html(context.text().replace('.edu.co', '<br />.edu.co'));
	});
	
	$('.node--type-pagina-basica-con-cita-e-imagen .field--name-body').clone()
	.insertAfter('.node--type-pagina-basica-con-cita-e-imagen .text-content').addClass('desk');
	
    //Agrega una clase para mostrar los elementos del submenÃº cuando carga la pÃ¡gina
    /*$('.page-investigaciones .menu--investigaciones .menu-item:nth-child(n+6):nth-child(-n+12)').each(function(){
        if($(this).hasClass('menu-item--active-trail')) {
            $('.page-investigaciones .menu--investigaciones .menu-item:nth-child(n+6):nth-child(-n+12)').addClass('show')
        }
    })*/
		
	// /aspirantes
	$('.banner-search .block-blockgroup .search-block-form .form-text')
		.attr('placeholder', $('.banner-search .block-blockgroup .search-block-form label').text());
		
	// En producciÃ³n no se imprimie .content1, se tuvo que poner manualmente, pero esto daÃ±a desarrollo
	$('.content1 > .content1').unwrap();
	$('.content2 > .content2').unwrap();
	$('.content3 > .content3').unwrap();
	$('.content4 > .content4').unwrap();
	$('.content5 > .content5').unwrap();
	$('.content6 > .content6').unwrap();
	
	$('.webform-submission-escribenos-eventos-especiales-form .form-email')
	.attr('placeholder', $('.webform-submission-escribenos-eventos-especiales-form label').text());
	
})(jQuery);



//	Objeto para manejo de cambios en pantalla
Responsive = {
    $desktop_width_limit: 1200,
    $desktop_width: 1180,
    $laptop_width: 1024,
    $tablet_width: 768,
    $mobile_width: 425,
    $mobile_l_width: 425,
    $mobile_m_width: 375,
    $mobile_s_width: 320,

    anchoPantalla: 0,
    tipoResolucion: '',
    subTipoResolucion: '',
    lastTipoResolucion: '',
    lastSubTipoResolucion: '',
    bnCambioTipoDeResolucion: false,
    bnCambioSubTipoDeResolucion: false,

    //	Retorna la resoluciÃ³n de la pantalla : Responsive.getResolution()
    getResolution: function() { return this.anchoPantalla; },

    //	Retorna el tipo de resoluciÃ³n de la pantalla : Responsive.getTypeResolution()
    //	============================================
    //	'Desktop', 'Tablet', 'Mobile'
    getTypeResolution: function() { return this.tipoResolucion; },
    //	Retorna el sub tipo de resoluciÃ³n de la pantalla : Responsive.getSubTypeResolution()
    //	================================================
    //	Dentro de Desktop Tenemos
    //	-------------------------
    //	- Desktop: Pantalla mayor al ancho maximo de la pagina (>1200px)
    //	- PageMaxWith: Pantalla menor al ancho maximo de la pagina (<1200px)
    //	- Laptop: Pantalla menor a 1024px (Igual que lo que dice chrome)
    //
    //	Dentro de Tablet Tenemos
    //	------------------------
    //	- Tablet: No existen mas subtipos
    //
    //	Dentro de Mobile Tenemos
    //	------------------------
    //	- Mobil_L: Pantalla menor a 425px (Igual que lo que dice chrome)
    //	- Mobil_M: Pantalla menor a 375px (Igual que lo que dice chrome)
    //	- Mobil_S: Pantalla menor a 320px (Igual que lo que dice chrome)
    getSubTypeResolution: function() { return this.subTipoResolucion; },
    //	Retorna true, si cambio de tipo de resoluciÃ³n Ej. Tablet -> Mobile
    qstnChangeTypeResolution: function() { return this.bnCambioTipoDeResolucion; },
    //	Retorna true, si cambio de Sub tipo de resoluciÃ³n Ej. Mobil_L -> Mobil_M
    qstnChangeSubTypeResolution: function() { return this.bnCambioSubTipoDeResolucion; },
    //	AÃ±ade una funciona a responsive
    arFunctionsToExecuteOnResize: [],
    addFunctionToExecuteOnResize: function(myFunction, bnEjecutar) { this.arFunctionsToExecuteOnResize[this.arFunctionsToExecuteOnResize.length] = myFunction; if (bnEjecutar) { this.accExecuteFunction(myFunction); }; },
    //	Cada vez que cambia de resoluciÃ³n ingresa aca para dar informaciÃ³n
    setInformation: function() {
        this.lastTipoResolucion = this.tipoResolucion;
        this.lastSubTipoResolucion = this.subTipoResolucion;
        this.anchoPantalla = jQuery(window).innerWidth();
        if (this.$desktop_width < this.anchoPantalla) {
            this.tipoResolucion = 'Desktop';
            this.subTipoResolucion = 'Desktop';
        }
        if (this.$laptop_width < this.anchoPantalla && this.anchoPantalla <= this.$desktop_width) {
            this.tipoResolucion = 'Desktop';
            this.subTipoResolucion = 'PageMaxWith';
        }
        if (this.$tablet_width < this.anchoPantalla && this.anchoPantalla <= this.$laptop_width) {
            this.tipoResolucion = 'Desktop';
            this.subTipoResolucion = 'Laptop';
        }
        if (this.$mobile_l_width < this.anchoPantalla && this.anchoPantalla <= this.$tablet_width) {
            this.tipoResolucion = 'Tablet';
            this.subTipoResolucion = 'Tablet';
        }
        if (this.$mobile_m_width < this.anchoPantalla && this.anchoPantalla <= this.$mobile_l_width) {
            this.tipoResolucion = 'Mobile';
            this.subTipoResolucion = 'Mobil_L';
        }
        if (this.$mobile_s_width < this.anchoPantalla && this.anchoPantalla <= this.$mobile_m_width) {
            this.tipoResolucion = 'Mobile';
            this.subTipoResolucion = 'Mobil_M';
        }
        if (0 < this.anchoPantalla && this.anchoPantalla <= this.$mobile_s_width) {
            this.tipoResolucion = 'Mobile';
            this.subTipoResolucion = 'Mobil_S';
        }

        if (this.lastTipoResolucion != this.tipoResolucion) { this.bnCambioTipoDeResolucion = true; } else { this.bnCambioTipoDeResolucion = false; }
        if (this.lastSubTipoResolucion != this.subTipoResolucion) { this.bnCambioSubTipoDeResolucion = true; } else { this.bnCambioSubTipoDeResolucion = false; }

        //console.info('ejecuto el on rezise');
        //	Pasa por cada funcion y la ejecuta
        for (var countFunctions = 0; countFunctions < this.arFunctionsToExecuteOnResize.length; countFunctions++) {
            var myFunction = this.arFunctionsToExecuteOnResize[countFunctions];
            //	Ejecuta la funciÃ³n
            this.accExecuteFunction(myFunction);
        }
    },
    //	Ejecuta la funciÃ³n y envia los parametros
    accExecuteFunction: function(myFunction) {
        myFunction({
            anchoPantalla: this.anchoPantalla,
            tipoResolucion: this.tipoResolucion,
            lastTipoResolucion: this.lastTipoResolucion,
            subTipoResolucion: this.subTipoResolucion,
            bnCambioTipoDeResolucion: this.bnCambioTipoDeResolucion,
            bnCambioSubTipoDeResolucion: this.bnCambioSubTipoDeResolucion
        });
    },
    //	arFunctionsOnResize: [],
    //	Las funciones que se aÃ±aden aca se ejecutan cuando cambia la resoluciÃ³n
    //	addFunctionToOnResize: function(myFunction)
    //	{
    //		this.arFunctionsOnResize[this.arFunctionsOnResize.length]=myFunction;
    //	}
};
jQuery(window).resize(function() { Responsive.setInformation(); });
Responsive.setInformation();


if (jQuery('body').hasClass('path-directorio')) {
    try {
        var textoP = jQuery('.view-id-directorio_facultad .view-content > div > p + h3');
        for (var countP = 0; countP < textoP.length; countP++) {
            textoP[countP].after(jQuery(textoP[countP]).prev('p')[0]);
        }
        var newH3 = jQuery('<h3></h3>');
        jQuery('.view-id-directorio_facultad .view-content > div').append(newH3);
        var textoP = jQuery('.view-id-directorio_facultad .view-content > div > h3');
        for (var countP = 0; countP < textoP.length - 1; countP++) {
            if (textoP[countP + 1]) {
                textoP[countP + 1].before(jQuery(textoP[countP]).prev('a')[0]);
            }
        }
        jQuery('.view-id-directorio_facultad .view-content > div > p, .view-id-directorio_facultad .view-content > div > a').addClass('uat-visibleblock');
        newH3.css({ display: 'none' });
        // menu directorios para academico
        jQuery('.view-filters').detach().appendTo(jQuery('.menu--menu-directorios'));
    } catch (err) {
        console.log(err);
    }
}