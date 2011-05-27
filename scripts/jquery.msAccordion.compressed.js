//menu Accordion
//author: Marghoob Suleman
//Date: 05th Aug, 2009
//Version: 1.0kin0.1
//web: www.giftlelo.com | www.marghoobsuleman.com
//
// Changes:
//
// 2011-05-27: v1.0 updated by Lee Braiden <lee.b@kintassa.com> to support:
//                  a) toggling the current panel when clicking on its header
//                  b) starting with all panels collapsed
//                  Changes create v1.0kin0.1
//
;(function($){
	$.fn.msAccordion = function(options) {
		options = $.extend({
					currentDiv:'1',
					previousDiv:'',
					vertical: false,
					defaultid:0,
					currentcounter:0,
					intervalid:0,
					autodelay:0,
					event:"click",
					start_collapsed: false,
					alldivs_array:new Array()
			}, options);
		$(this).addClass("accordionWrapper");
		$(this).css({overflow:"hidden"});

		var elementid = $(this).attr("id");
		var allDivs = this.children();
		if(options.autodelay>0)  {
			$("#"+ elementid +" > div").bind("mouseenter", function(){
														   pause();
														   });
			$("#"+ elementid +" > div").bind("mouseleave", function(){
																  startPlay();
																  });
		}
		//set ids
		allDivs.each(function(current) {
								 var iCurrent = current;
								 var sTitleID = elementid+"_msTitle_"+(iCurrent);
								 var sContentID = sTitleID+"_msContent_"+(iCurrent);
								 var currentDiv = allDivs[iCurrent];
								 var totalChild = currentDiv.childNodes.length;
								 var titleDiv = $(currentDiv).children("div.title");
								 titleDiv.attr("id", sTitleID);
								 var contentDiv = $(currentDiv).children("div.content");
								 contentDiv.attr("id", sContentID);
								 options.alldivs_array.push(sTitleID);
								 //$("#"+sTitleID).click(function(){openMe(sTitleID);});
								 $("#"+sTitleID).bind(options.event, function(){pause();chooseMe(sTitleID, current);});
								 });
		
		//make vertical
		if(options.vertical) {makeVertical();};
		if (!options.start_collapsed) {
			//open default
			openMe(elementid+"_msTitle_"+options.defaultid);
		}
		if(options.autodelay>0) {startPlay();};

		function activePanelNum() {
			return_val = null;
			allDivs.each(function (panel_num, val) {
				content = jQuery(val).children('div.content');
				if (content.css("display") != "none") {
					return_val = panel_num;
					return;
				}
			});

			return return_val;
		}
		
		function chooseMe(chosen_panel_id, chosen_panel_num) {
			active_panel_num = activePanelNum();

			if (active_panel_num == null || active_panel_num != chosen_panel_num) {
				openMe(chosen_panel_id);
			} else {
				toggleMe(chosen_panel_id);
			}
		}

		function print_r(x, max, sep, l) {

			l = l || 0;
			max = max || 5;
			sep = sep || ' ';

			if (l > max) {
				return "[WARNING: Too much recursion]\n";
			}

			var
				i,
				r = '',
				t = typeof x,
				tab = '';

			if (x === null) {
				r += "(null)\n";
			} else if (t == 'object') {

				l++;

				for (i = 0; i < l; i++) {
					tab += sep;
				}

				if (x && x.length) {
					t = 'array';
				}

				r += '(' + t + ") :\n";

				for (i in x) {
					try {
						r += tab + '[' + i + '] : ' + print_r(x[i], max, sep, (l + 1));
					} catch(e) {
						return "[ERROR: " + e + "]\n";
					}
				}

			} else {

				if (t == 'string') {
					if (x == '') {
						x = '(empty)';
					}
				}

				r += '(' + t + ') ' + x + "\n";

			}

			return r;

		}

		function toggleMe(div) {
			nxt = $("#"+div).next();
			if(options.vertical) {
				nxt.slideToggle("slow");
			} else {
				nxt.hide("slow");
			};
		}
		
		function openMe(id) {
			var sTitleID = id;
			var iCurrent = sTitleID.split("_")[sTitleID.split("_").length-1];
			options.currentcounter = iCurrent;
			var sContentID = id+"_msContent_"+iCurrent;
			if($("#"+sContentID).css("display")=="none") {
				if(options.previousDiv!="") {
					closeMe(options.previousDiv);
				};
				if(options.vertical) {
					$("#"+sContentID).slideDown("slow");
				} else {
					$("#"+sContentID).show("slow");
				}
				options.currentDiv = sContentID;
				options.previousDiv = options.currentDiv;
			};
		};
		function closeMe(div) {
			if(options.vertical) {
				$("#"+div).slideUp("slow");
			} else {
				$("#"+div).hide("slow");
			};
		};	
		function makeVertical() {
			$("#"+elementid +" > div").css({display:"block", float:"none", clear:"both"});
			$("#"+elementid +" > div > div.title").css({display:"block", float:"none", clear:"both"});
			$("#"+elementid +" > div > div.content").css({clear:"both"});
		};
		function startPlay() {
			options.intervalid = window.setInterval(play, options.autodelay*1000);
		};
		function play() {
			var sTitleId = options.alldivs_array[options.currentcounter];
			openMe(sTitleId);
			options.currentcounter++;
			if(options.currentcounter==options.alldivs_array.length) options.currentcounter = 0;
		};
		function pause() {
			window.clearInterval(options.intervalid);
		};
		}
})(jQuery);