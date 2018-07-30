var fscreenheight = window.innerHeight - 100;
							var isFullScreen = false;
							var gameIdDiv = "#gamebox";
							
							var gamediv_width = $( gameIdDiv ).css( "width" );
							var gamediv_height = $( gameIdDiv ).css( "height" );
							var gamemovie_height = $( "#gameMovie" ).css( "height" );
							var advertGameContainer_height = $( "#advertGameContainer" ).css( "height" );
							
							var gamediv_position = $( gameIdDiv ).css( "position" );
							var gamediv_zindex = $( gameIdDiv ).css( "z-index" );
							var gamediv_left = $( gameIdDiv ).css( "left" );
							var gamediv_top = $( gameIdDiv ).css( "top" );
							var gamediv_margintop = $( gameIdDiv ).css( "margin-top" );
							
								function showFullscreenGame(){
									if(!isFullScreen){
										isFullScreen = true;
										 $( gameIdDiv ).css( "width", "100%" );
										 $( gameIdDiv ).css( "height", fscreenheight+"px" );
										 $("#gameMovie").height(fscreenheight+"px");
										 $("#gameMovie").width("100%");
										 $("#advertGameContainer").height(fscreenheight+"px");
										 $("#game_under_menu").height(fscreenheight+"px");
										 $( gameIdDiv ).css( "position", "fixed" );
										 $( gameIdDiv ).css( "z-index", "9999999999" );
										 $( gameIdDiv ).css( "left", "0" );
										 $( gameIdDiv ).css( "top", "0" );

										 $( gameIdDiv ).css( "margin-top", "0px" );
										$( "#fullscreen_overlay" ).css( "display", "block" );
										$( "header" ).css( "display", "none" );
											
										$( "#game_under_menu" ).css( "height", "100px" );

										 $('html, body').animate({
											scrollTop: $("#gamebox").offset().top
										}, 500);
	 									$("#fullscreen_icon").attr('src','/local/siteimg/fullscreen_ugame_back.png');   
				
									}else{
										isFullScreen = false;
										 $( gameIdDiv ).css( "width", gamediv_width );
										 $( gameIdDiv ).css( "height", gamediv_height );
										 $("#gameMovie").height(gamemovie_height);
										 $("#advertGameContainer").height(advertGameContainer_height);
										 $( gameIdDiv ).css( "position", gamediv_position);
										 $( gameIdDiv ).css( "z-index", gamediv_zindex);
										 $( gameIdDiv ).css( "left", gamediv_left);
										 $( gameIdDiv ).css( "top", gamediv_top );

										 $( gameIdDiv ).css( "margin-top", "gamediv_margintop" );
										$( "#fullscreen_overlay" ).css( "display", "none" );
										$( "header" ).css( "display", "block" );
										$( "#gicons_under_game" ).css( "margin-top", "70px" );
											
										$('html, body').animate({
											scrollTop: $("#gamebox").offset().top
										}, 500);
										
										$( "#game_under_menu" ).css( "height", "60px" );
										
										$("#fullscreen_icon").attr('src','/local/siteimg/fullscreen_ugame.png');   
									}
								}