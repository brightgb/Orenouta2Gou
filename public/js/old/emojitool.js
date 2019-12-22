/*  ------------------------------------------------
	絵文字ツール
  copyright(c) iBrid Co.,Ltd. All Rights Reserved.
  ------------------------------------------------ */
/* 割り当て */
$(document).ready(
	function()
	{
		var $targets	= $(".emoji_enabled");
		__ankPrefix__	= "btn";
		__keyPrefix__	= "key";
		__containerid__	= "emoji_container";
		__emoji_item__	= "emoji_item";

		if( $targets.size() <= 0 )
			return;

		$targets.before(
			function()
			{
				return _emojiUtil.createButton( __ankPrefix__ + this.id )
			}
		);

		$targets.each(
			function()
			{
				SetupEmojiTool(
					__keyPrefix__ + this.id
					,"#" + __ankPrefix__ + this.id
					,"#" + this.id
					,EmojiPageList
					,__containerid__
					,"."+__emoji_item__
				);
			}
		);
	}
);

var _emojiWindowIds = new Array();
/***
 絵文字ツールの初期化
	セレクタ
	windowOpenBtn;	//絵文字ウィンドウを開くボタンのセレクタ
	textArea;		//絵文字を入力するtextarea/textbox のセレクタ
	pageList		//pageの連想配列（ ex { title:url, title:url ...} ）
	containerId		//絵文字を格納する領域のセレクタ
	emoji;			//絵文字のセレクタ
*/
function SetupEmojiTool(key, windowOpenBtn, textArea, pageList, containerId, emoji)
{
	$.ajaxSetup({mimeType: "text/html;charset=Shift_JIS"});

	///const
	var _classPage	= "emoji_page";				//page用
	var _classMask	= "emoji_window_mask";		//mask用
	var _fadeTime	= 200;
	var _classEmojiContainer = "x_emoji";

	var windowId		= key + "_" +"em_window";
	var pagerId			= key + "_" +"em_pager";
	var closeBtnId		= key + "_" +"em_closeBtn";
	var myContainerId	= key + "_" + containerId.replace("#","");
	var bufferId		= key + "_" + "em_buffer";
	var bsbtnId			= key + "_" + "em_bsBtn";
	containerId = containerId.substring(0,1) != "#" ? "#" + containerId : containerId;

	//optionのチェック
	if( !this.EmojiOption )
	{
		this.EmojiOption = {};
	}
	if( !EmojiOption.SmartPhone )
	{
		EmojiOption.SmartPhone = false;
	}

	//ready event
	$(document).ready(
		function()
		{
			///create window
			var $w = $( _emojiUtil.createWindow(windowId, pagerId, closeBtnId, myContainerId, bufferId, bsbtnId) );
			$w.appendTo("body");

			///Setup Selector
			var $openBtn		= $(windowOpenBtn);
			var $window			= $("#"+windowId);
			var $closeBtn		= $("#"+closeBtnId);
			var $pager			= $("#"+pagerId);
			var $myContainer	= $w.find("#"+myContainerId);
			var $textArea		= $(textArea);
			var $mask			= $("<div> </div>").addClass(_classMask); //mask
			var $buffer			= $("#"+bufferId);
			var buffData		= new Array();
			var $bsBtn			= $("#"+bsbtnId);

			//windowlist
			//_emojiWindowIds.push($window);

			///setup mask
			$mask.appendTo("body");

			///delegete
			var __showWindow;
			var __closeWindow;
			var __insertTextAtCaret;
			var __emojiBufferPaste;
			var __emojiBufferClear;
			var __emojiBSKey;

			//For IE only delegate
			var isIE = $.browser.msie;
			var __ie__caretPosition = 0;		//textbox only
			var __ie__recordingCaretPosision;	//delegate

			///setup textarea event handler
			if( isIE )
			{
				__insertTextAtCaret = function(txt)
					{
						$textArea.focus("");
						var np = __ie__caretPosition + txt.length;
						var s = $textArea.val();
						$textArea.val( s.substr(0, __ie__caretPosition) + txt + s.substr(__ie__caretPosition) );
					};

				__ie__recordingCaretPosision = function()
					{
						$textArea.focus("");
						var Sel = document.selection.createRange ();
						Sel.moveStart ('character', -$textArea.val().length );
						__ie__caretPosition = Sel.text.length;

						var start = 0;
						if( $textArea.val().length > 5 )
						{
							start = Sel.text.indexOf($textArea.val().substring(0,5), 0);
						}
						else
						{
							start = Sel.text.indexOf($textArea.val(), 0);
						}
						//for textarea patch
						__ie__caretPosition = ( start < 0 ? 0 : __ie__caretPosition - start );
					}

				if( $textArea.attr("type").toLowerCase() == "text" )
				{
					__insertTextAtCaret = function(txt)
						{
							$textArea.focus();
							var np = __ie__caretPosition + txt.length;
							var s = $textArea.val();
							$textArea.val( s.substr(0, __ie__caretPosition) + txt + s.substr(__ie__caretPosition) );
						};

					__ie__recordingCaretPosision = function()
						{
							$textArea.focus();
							var Sel = document.selection.createRange();
							Sel.moveStart( "character", - $textArea.val().length );
							__ie__caretPosition = Sel.text.length;
						};
				}
			}
			else //non IE
			{
				__insertTextAtCaret = function(txt)
				{
					$textArea.focus();
					var pos = $textArea.get(0).selectionStart;
					var np = pos + txt.length;
					var s = $textArea.val();

					$textArea.val( s.substr(0, pos) + txt + s.substr(pos) );
					$textArea[0].setSelectionRange(np, np);
				};
			}

			///emoji buffer behavior
			__emojiBufferPaste = function()
			{
				if( buffData.length > 0 )
				{
					__insertTextAtCaret( buffData.join("") );
					$textArea.trigger("keyup");
				}
			};
			__emojiBufferClear = function()
			{
				$buffer.empty();
				buffData = new Array();
			}

			__emojiBSKey = function()
			{
				if( buffData.length > 0 )
				{
					$buffer.children().last().remove();
					buffData.pop();
				}
			}


			///window event handler
			if( EmojiOption.SmartPhone )
			{
				__showWindow  = function(e)
					{
						//mask process
						var view = _emojiUtil.getWindowSize();
						var pos = _emojiUtil.getViewPosition();
						var doc = _emojiUtil.getDocumentSize();

						$mask.css({"width":doc.width,"height":doc.height+500}).show();

						//Set the popup window to center
						$targetTxt = $('#' + $(this).attr("id").replace(__ankPrefix__, ""));
						$window.css("top",  $targetTxt.offset().top + $targetTxt.height() + 10);
						$window.css("left", $targetTxt.offset().left );
						$window.css("width",$targetTxt.css("width"));
						$window.show();

						//for Android
						var $targets = $("a");
						var i=0;

						for( i=0; i<_emojiWindowIds.length; i++ )
						{
							$targets = $targets.not(_emojiWindowIds[i].find("a"));
						}

						$targets.each(
							function()
							{
								var $this = $(this);
								$this.attr("xhref", $this.attr("href"));
								$this.removeAttr("href");
								$this.addClass("no-android-highlight");
								//alert( $("<div>").append( $this.clone() ).html());
							}
						);
					};

				__closeWindow = function()
					{
						$mask.hide();
						$window.hide();

						$("a[xhref]").each(
							function()
							{
								var $this=$(this);
								$this.attr("href", $this.attr("xhref"));
								$this.removeAttr("xhref");
								$this.removeClass("no-android-highlight");
								//alert( $("<div>").append($this.clone()).html() );
							}
						);
					};
			}
			else
			{
				__showWindow  = function(e)
					{
						var winPos = $textArea.offset();
						$window.css("top", winPos.top + $textArea.outerHeight() );
						$window.css("left", winPos.left );
						$window.fadeIn( _fadeTime );
					};

				__closeWindow = function()
					{
						$mask.hide();
						$window.fadeOut( _fadeTime );
					};

				// タイトルバーをドラッグしたとき
				var $title = $window.find('.emoji_palette_title');
				$title.bind("mousedown",
					function(ev1)
					{
						var mx = ev1.pageX;
						var my = ev1.pageY;

						$title.bind("mousemove",
							function(ev2)
							{
								var $pos = $window.position();
								$window.css({'top': $pos.top + ev2.pageY - my, 'left': $pos.left + ev2.pageX - mx});
								mx = ev2.pageX;
								my = ev2.pageY;
								return false;
							}
						);
						$title.bind("mouseup", function(){ $title.unbind('mousemove'); $title.unbind('mouseup');});
						return false;
					}
				);
			}



			//event bind
			$bsBtn.bind("click", __emojiBSKey);
			$closeBtn.bind("click", function(){ __closeWindow(); __emojiBufferPaste(); });
			$openBtn.bind("click",
				function()
				{
					__emojiBufferClear();

					$("html,body").animate({scrollTop:$(this).offset().top - $('#header_box').outerHeight(true)},500,'swing');

					//check pager
					if( _emojiUtil.getStringLength( $pager.html() ) > 0 )
						return;

					//link create & event attach
					var $anchor;
					var target;
					for( var pageKey in pageList )
					{
						ajaxTarget = pageList[pageKey] + " div" + containerId; //url + id

						$anchor = $("<a />");
						$anchor.addClass(_classPage).text(pageKey);
						$anchor.appendTo($pager);

						//event bind
						$anchor.bind(
							"click",
							{"target":ajaxTarget, "key":pageKey },
							function(eo)
							{
								$myContainer.find( "."+_classEmojiContainer ).hide();
								var $_page = $myContainer.find("." + eo.data.key);


								if( _emojiUtil.getStringLength( $_page.html() ) <= 0 )
								{
									$_page = $("<div />").addClass(eo.data.key).addClass( _classEmojiContainer );
									$_page.appendTo( $myContainer );

									$_page.load(
										eo.data.target,
										function()
										{
											$("#" + myContainerId + " ." + eo.data.key + " " + emoji).click(
												function()
												{
													var $__clone = $(this).find(":first-child").clone();
													$__clone.removeClass("emoji_inner");
													$__clone.addClass("emoji_buffer_item");
													$buffer.append( $__clone );
													buffData.push(decodeURIComponent(this.id));
												}
											);

											$myContainer.find( "."+_classEmojiContainer ).hide();
											$_page.show();
										}
									);

								}
								$myContainer.find( "."+_classEmojiContainer ).hide();
								$_page.show();
							}
						);
					}
					$pager.find("a:first").triggerHandler("click");
				}
			);
			$openBtn.bind("click", __showWindow);

			$mask.bind(
				"click",
				function(){	$closeBtn.triggerHandler("click");	}
			);

			// ie && textbox only events
			if( __ie__recordingCaretPosision )
			{
				$textArea.bind(
					{
						"keyup" :__ie__recordingCaretPosision
						,"click" :__ie__recordingCaretPosision
					}
				);
			}
		}
	);
}

//utilty method
var _emojiUtil =
{
	isSmartPhone: function()
	{
		return (
			navigator.userAgent.indexOf("iPhone") > 0
			|| navigator.userAgent.indexOf("iPad") > 0
			|| navigator.userAgent.indexOf("Android") > 0
		);
	},
	getWindowSize: function()
	{
		var result = {width:$(window).width(), height:$(window).height()};
		return result;
	},
	getViewPosition: function()
	{
		var result = {top:$(window).scrollTop(), left:$(window).scrollLeft()};
		return result;
	},
	getDocumentSize: function()
	{
		var result = {width:$(document).width(), height:$(document).height()};
		return result;
	},
	createWindow: function(windowId, pagerId, closebtnId, containerId, bufferId, bsbtnId)
	{
		var w =
			"<div id='" + windowId + "' class='emoji_palette clearfix' style='display:none;' >"+
				"<div class='emoji_palette_title clearfix'>"+
					"<div class='emoji_window_button'><a id='"+ closebtnId +"' class='emoji_palette_close'>確定</a></div>"+
				"</div>"+
				"<div class='emoji_buffer_area clearfix'>"+
					"<div id='"+ bufferId +"' class='emoji_buffer'></div><div class='emoji_bs_key'><a id='"+bsbtnId+"'>クリア</a></div>"+
				"</div>"+
				"<div id='" + containerId + "' ></div>"+
				"<div class='emoji_footer'>"
					+ "<div id='"+ pagerId +"' class='emoji_pager'></div>"+
				"</div>" +
			"</div>";
		return w;
	},

	createButton: function(id)
	{
		return "<a class='emoji_open_button' id='"+ id +"' href='#'>絵文字</a><br />"
	},

	getStringLength: function(obj)
	{
		var result = 0;
		if( typeof obj == "string")
		{
			result = obj.length;
		}
		return result;
	}
};
