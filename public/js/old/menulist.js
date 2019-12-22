$(function() {
	var min_size = 0;
	var panel_open_flag = false; 

	var TitleHeight	 = $('.header_box').outerHeight(true);
	var FooterHeight = 82;	//$('.footer_fix').outerHeight(true) + 5;
	var WindowHeight = window.innerHeight - FooterHeight - TitleHeight; //ćĘĚł - footer - header
	var DummyWidth	 = 60;

	$('.menu_button').css('cursor', 'pointer').click(function() {
		if (panel_open_flag) {
			$('#dummyContent00').remove();
			$('#menuList').animate({'width' : min_size}, {
				'complete' : function() {
					$(".menu_button").removeClass('active');
					$('#menuList').css('display', 'none');
					panel_open_flag = false;
//					alert("flag1:" + panel_open_flag + "flag2" + panel_open_flag2);
				}
			});
			$('#menuDetail01').animate({'width' : min_size}, {
				'complete' : function() {
					$('#menuDetail01').css('display', 'none');
				}
			});
			$('#menuDetail02').animate({'width' : min_size}, {
				'complete' : function() {
					$('#menuDetail02').css('display', 'none');
				}
			});
			$('#menuDetail03').animate({'width' : min_size}, {
				'complete' : function() {
					$('#menuDetail03').css('display', 'none');
				}
			});
			$('#menuDetail04').animate({'width' : min_size}, {
				'complete' : function() {
					$('#menuDetail04').css('display', 'none');
				}
			});
			$('#menuDetail05').animate({'width' : min_size}, {
				'complete' : function() {
					$('#menuDetail05').css('display', 'none');
				}
			});
			$('#menuDetail06').animate({'width' : min_size}, {
				'complete' : function() {
					$('#menuDetail06').css('display', 'none');
				}
			});
			$('#menuDetail07').animate({'width' : min_size}, {
				'complete' : function() {
					$('#menuDetail07').css('display', 'none');
				}
			});
			$('#menuDetail21').animate({'width' : min_size}, {
				'complete' : function() {
					$('#menuDetail21').css('display', 'none');
				}
			});
			$('#menuDetail22').animate({'width' : min_size}, {
				'complete' : function() {
					$('#menuDetail22').css('display', 'none');
				}
			});
		} else {
			$('#menuList').css('display', 'block').animate({'width' : $(document.body).width() - DummyWidth}, {
				'complete' : function() {
					$(".menu_button").addClass('active');
//					$('<div id="dummyContent00"></div>').height($(document.body).height()).insertAfter($('#menuList'));
					$('<div id="dummyContent00"></div>').insertAfter($('#menuList'));
					panel_open_flag = true;
				}
			});
		}
		window.scrollTo(0, 0);
	});

	$('.menu_detail01').css('cursor', 'pointer').click(function() {
		$('.backmenu').removeClass('back_active');
		$('#menuDetail01').css('display', 'block').animate({'width' : $(document.body).width() - DummyWidth}, {
			'complete' : function() {
				$("#menuList").css('display', 'none');
				panel_open_flag = true;
			}
		});
		window.scrollTo(0, 0);
	});

	$('.menu_detail02').css('cursor', 'pointer').click(function() {
		$('.backmenu').removeClass('back_active');
		$('#menuDetail02').css('display', 'block').animate({'width' : $(document.body).width() - DummyWidth}, {
			'complete' : function() {
				$("#menuList").css('display', 'none');
				panel_open_flag = true;
			}
		});
		window.scrollTo(0, 0);
	});

	$('.menu_detail03').css('cursor', 'pointer').click(function() {
		$('.backmenu').removeClass('back_active');
		$('#menuDetail03').css('display', 'block').animate({'width' : $(document.body).width() - DummyWidth}, {
			'complete' : function() {
				$("#menuList").css('display', 'none');
				panel_open_flag = true;
			}
		});
		window.scrollTo(0, 0);
	});

	$('.menu_detail04').css('cursor', 'pointer').click(function() {
		$('.backmenu').removeClass('back_active');
		$('#menuDetail04').css('display', 'block').animate({'width' : $(document.body).width() - DummyWidth}, {
			'complete' : function() {
				$("#menuList").css('display', 'none');
				panel_open_flag = true;
			}
		});
		window.scrollTo(0, 0);
	});

	$('.menu_detail05').css('cursor', 'pointer').click(function() {
		$('.backmenu').removeClass('back_active');
		$('#menuDetail05').css('display', 'block').animate({'width' : $(document.body).width() - DummyWidth}, {
			'complete' : function() {
				$("#menuList").css('display', 'none');
				panel_open_flag = true;
			}
		});
		window.scrollTo(0, 0);
	});

	$('.menu_detail06').css('cursor', 'pointer').click(function() {
		$('.backmenu').removeClass('back_active');
		$('#menuDetail06').css('display', 'block').animate({'width' : $(document.body).width() - DummyWidth}, {
			'complete' : function() {
				$("#menuList").css('display', 'none');
				panel_open_flag = true;
			}
		});
		window.scrollTo(0, 0);
	});

	$('.menu_detail07').css('cursor', 'pointer').click(function() {
		$('.backmenu').removeClass('back_active');
		$('#menuDetail07').css('display', 'block').animate({'width' : $(document.body).width() - DummyWidth}, {
			'complete' : function() {
				$("#menuList").css('display', 'none');
				panel_open_flag = true;
			}
		});
		window.scrollTo(0, 0);
	});

	$('.menu_detail21').css('cursor', 'pointer').click(function() {
		$('.backmenu20').removeClass('back_active');
		$('#menuDetail21').css('display', 'block').animate({'width' : $(document.body).width() - DummyWidth}, {
			'complete' : function() {
				$("#menuDetail02").css('display', 'none');
				panel_open_flag = true;
			}
		});
		window.scrollTo(0, 0);
	});

	$('.menu_detail22').css('cursor', 'pointer').click(function() {
		$('.backmenu20').removeClass('back_active');
		$('#menuDetail22').css('display', 'block').animate({'width' : $(document.body).width() - DummyWidth}, {
			'complete' : function() {
				$("#menuDetail02").css('display', 'none');
				panel_open_flag = true;
			}
		});
		window.scrollTo(0, 0);
	});

	$('.backmenu').css('cursor', 'pointer').click(function() {
		$('.backmenu').addClass('back_active');
		$('#menuList').css('display', 'block').animate({'width' : $(document.body).width() - DummyWidth}, {
			'complete' : function() {
				panel_open_flag = true;
			}
		});
		$('#menuDetail01').animate({'width' : min_size}, {
			'complete' : function() {
				$('#menuDetail01').css('display', 'none');
			}
		});
		$('#menuDetail02').animate({'width' : min_size}, {
			'complete' : function() {
				$('#menuDetail02').css('display', 'none');
			}
		});
		$('#menuDetail03').animate({'width' : min_size}, {
			'complete' : function() {
				$('#menuDetail03').css('display', 'none');
			}
		});
		$('#menuDetail04').animate({'width' : min_size}, {
			'complete' : function() {
				$('#menuDetail04').css('display', 'none');
			}
		});
		$('#menuDetail05').animate({'width' : min_size}, {
			'complete' : function() {
				$('#menuDetail05').css('display', 'none');
			}
		});
		$('#menuDetail06').animate({'width' : min_size}, {
			'complete' : function() {
				$('#menuDetail06').css('display', 'none');
			}
		});
		$('#menuDetail07').animate({'width' : min_size}, {
			'complete' : function() {
				$('#menuDetail07').css('display', 'none');
			}
		});
		window.scrollTo(0, 0);
	});

	$('.backmenu20').css('cursor', 'pointer').click(function() {
		$('.backmenu20').addClass('back_active');
		$('#menuDetail02').css('display', 'block').animate({'width' : $(document.body).width() - DummyWidth}, {
			'complete' : function() {
				panel_open_flag = true;
			}
		});
		$('#menuDetail21').animate({'width' : min_size}, {
			'complete' : function() {
				$('#menuDetail21').css('display', 'none');
			}
		});
		$('#menuDetail22').animate({'width' : min_size}, {
			'complete' : function() {
				$('#menuDetail22').css('display', 'none');
			}
		});
		window.scrollTo(0, 0);
	});

	$('.menuClose').css('cursor', 'pointer').click(function() {
		$('#dummyContent00').remove();
		$(".menu_button").removeClass('active');
		$('#menuList').animate({'width' : min_size}, {
			'complete' : function() {
				$('#menuList').css('display', 'none');
				panel_open_flag = false;
			}
		});
		$('#menuDetail01').animate({'width' : min_size}, {
			'complete' : function() {
				$('#menuDetail01').css('display', 'none');
				panel_open_flag = false;
			}
		});
		$('#menuDetail02').animate({'width' : min_size}, {
			'complete' : function() {
				$('#menuDetail02').css('display', 'none');
				panel_open_flag = false;
			}
		});
		$('#menuDetail03').animate({'width' : min_size}, {
			'complete' : function() {
				$('#menuDetail03').css('display', 'none');
				panel_open_flag = false;
			}
		});
		$('#menuDetail04').animate({'width' : min_size}, {
			'complete' : function() {
				$('#menuDetail04').css('display', 'none');
				panel_open_flag = false;
			}
		});
		$('#menuDetail05').animate({'width' : min_size}, {
			'complete' : function() {
				$('#menuDetail05').css('display', 'none');
				panel_open_flag = false;
			}
		});
		$('#menuDetail06').animate({'width' : min_size}, {
			'complete' : function() {
				$('#menuDetail06').css('display', 'none');
				panel_open_flag = false;
			}
		});
		$('#menuDetail07').animate({'width' : min_size}, {
			'complete' : function() {
				$('#menuDetail07').css('display', 'none');
				panel_open_flag = false;
			}
		});
		$('#menuDetail21').animate({'width' : min_size}, {
			'complete' : function() {
				$('#menuDetail21').css('display', 'none');
				panel_open_flag = false;
			}
		});
		$('#menuDetail22').animate({'width' : min_size}, {
			'complete' : function() {
				$('#menuDetail22').css('display', 'none');
				panel_open_flag = false;
			}
		});
		window.scrollTo(0, 0);
	});

	$(window).on('resize load', function(evt) {
		if (panel_open_flag == false) {
			return;
		}
		
		$('#menuList').css('width', $(document.body).width() - DummyWidth);
		$('#menuDetail01').css('width', $(document.body).width() - DummyWidth);
	});

});
