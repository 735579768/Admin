//dom加载完成后执行的js
;
var reloadbool=true;//请求后刷新判断
var msgtime=3;//信息显示时间
$(function(){

//给元素注册触发ajax-post操作的事件
$('.ajax-post').bind('click',function(){
	$(this).addClass('disabled');
	ajaxform($(this));
	});
//失去焦点提交事件
$('.ajax-post-blur').bind('blur',function(){
	$(this).addClass('disabled');
	ajaxform($(this));
	});
$('.ajax-post-blur-noreload').bind('blur',function(){
	$(this).addClass('disabled');
	ajaxform($(this),1,false);
	});

/*****************************/
$('.ajax-href').bind('click',function(){
	$(this).addClass('disabled');
	return ajaxhref($(this));
	});
$('.ajax-href-del').bind('click',function(){
	if(!confirm('确定要见删除吗?'))return false;
	$(this).addClass('disabled');
	return ajaxhref($(this));
	});

});

function ajaxhref(obj){
	if(typeof(arguments[2])!='undefined')reloadbool=arguments[2];
	if(typeof(arguments[1])!='undefined')msgtime=arguments[1];
		url=obj.attr('href');
		$.ajax({
			  'type':'POST',
			  'url': url, 
			  'success':function(da){
					topmsg(da);
				  },
			  dataType:'JSON'
			});
		return false;
	}
/**
  *全局ajax提交form表单数据thisobj为触发事件的元素
  *@param thisobj 触发事件的元素
  *可以添加另外两个参数第二个控制时间第三个控制刷新
  *备注：
  *可以添加两个函数：
  *_before_post()提交前调用
  *_after_post()提交后调用
  */
function ajaxform(thisobj){
	if(typeof(arguments[2])!='undefined')reloadbool=arguments[2];
	if(typeof(arguments[1])!='undefined')msgtime=arguments[1];
	
	try{
	if(typeof(_before_post)=='function')_before_post();
	var thisobj,obj,a,url;
	a=''
	formobj=thisobj.parents('form');
	formobj.submit(function(e) {
        return false;
    });
	url=formobj.attr('action');
	postdata=formobj.serialize();
	a='{'+a+'}';
	b=eval('('+a+')');
	$.ajax({
		'url':url,
		'type':'POST',
		'datatype':'JSON',
		'data':postdata,
		'success': function(da){
				topmsg(da);
			}
		
		});	
	}catch(e){
		alert(e.name + ": " + e.message);
		}
	}
/***************************************提示信息*******************************************/
//网页上面弹出信息
function topmsg(da){
	if(typeof(arguments[2])!='undefined')reloadbool=arguments[2];
	if(typeof(arguments[1])!='undefined')msgtime=arguments[1];
	$('body').css('posttion','relative');
	$('#topmsg').remove();
	$('body').append('<div id="topmsg" style="z-index:99999;padding:10px;font-weight:bolder;text-align:center; color:#f00;display:block;position:fixed;top:0px; background:#fff; left:50%;border-radius: 10px;-webkit-box-shadow: 0px 4px 13px rgba(0,0,0,0.30);-moz-box-shadow: 0px 4px 13px rgba(0,0,0,0.30);box-shadow: 0px 4px 13px rgba(0,0,0,0.30);_left:45%;_position:absolute;_bottom:auto;_top:expression(eval(document.documentElement.scrollTop));">'+da.info+'<span>,'+msgtime+'</span></div>');
	$('#topmsg').css({marginLeft:'-'+($('#topmsg').outerWidth()/2)+'px',top:'-'+$('#topmsg').outerHeight()+'px'});
	$('#topmsg').stop(true).animate({
			top:$('#topmsg').outerHeight()/2+20+'px'
		},200,function(){
				$('#topmsg').stop(true).animate({top:'20px'},100);
			});
	if(da.status=='0'){
		$('#topmsg').css({background:'#ff6666',color:'#ffffff'});
		}else{
		$('#topmsg').css({background:'#4bbd00',color:'#ffffff'});	
			}
	//倒计时
	var timeid=setInterval(function(){
		if(msgtime>1){
			$('#topmsg span').html(','+(--msgtime));
		}else{
			clearInterval(timeid);
			$('#topmsg').stop(true).animate({
						top:$('#topmsg').outerHeight()/2+'px'
					},100,function(){
							$('#topmsg').stop(true).animate({top:'-'+$('#topmsg').outerHeight()+'px'},200,function(){
								$('#topmsg').remove();
								$('.disabled').removeClass('disabled');
								//当出现未知请求的时候页面不刷新
								if(typeof(da.info)!='undefined' && typeof(da.norefresh)=='undefined'){
								if(reloadbool){
									if(da.url!=''){
										window.location=da.url;
										}else{
											if(da.status===1){
											window.location.reload();
											}
										}
								}
								}
								//后置操作
								if(typeof(_after_post)=='function')_after_post();
								});
							
						});				
			}
		},1000);
	}
////在元素下面提示
//function tooltipmsg(obj,str){
//	//$('.tooltipmsg').remove();
//	obj.wrap('<span class=".msgwrap" style="position:relative;"></span>');
//	obj.parent().append('<span class="tooltipmsg" style="bottom:'+(obj.height()+5)+'px;">'+str+'</span>');
//	setTimeout(function(){	
//		$('.tooltipmsg').fadeOut(300,function(){
//			$('.tooltipmsg').remove();
//			obj.unwrap();
//			});		
//		},2000);
//
//	}
////全屏弹窗提示
//function alertmsg(str){
//	$('body').append('<div class="background" style="display:none"></div>');
//	$('body').append('<div class="alertmsg" style="display:none">'+str+'</div>');
//	$('.background').show();
//	$('.alertmsg').show();
//	setTimeout(function(){
//			$('.alertmsg').fadeOut(100,function(){
//				$('.background').remove();
//				$('.alertmsg').remove();
//				if(typeof(_after_post)=='function')_after_post();		
//				});		
//		},1000);
//
//	}
/***********弹出一个小窗口更改信息***************/
$(function(){
	$('.input-msg').bind('dblclick',function(){
		//取id
		var obj=$(this);
		$('#input-msg').remove();
		var w=obj.outerWidth();
		var h=obj.outerHeight();
		var v=obj.html();
		obj.css('position','relative');
		var str='<div id="input-msg" style=" padding:5px;width:350px;z-index:999900;background:#fff; border:solid 4px #6bb05f;position:absolute;top:'+(h/2)+'px;left:'+(w/2)+'px"><input class="form-control" style="width:180px; float:left; margin-right:5px;" type="text" value="" /><a class="btn btn-primary save" href="javascript:;">保存</a><a href="javascript:;" class="btn btn-warning cancel" >取消</a></div>';
		obj.append(str);
		obj.find('div input').val(v);
		obj.find('div').hover(function(){},function(){$(this).remove();});
		obj.find('.save').bind('click',function(){
				var url=obj.attr('data-url');
				url=url?url:'/admin.php/Index/updatefield.html';
				var field=obj.attr('data-field');
						$.ajax({
						'url':url,
						'type':'POST',
						'datatype':'JSON',
						'data':{id:obj.attr('data-id'),field:obj.attr('data-field'),table:obj.attr('data-table'),value:obj.find('div input').val()},
						'success': function(da){
								if(da.status=='0'){
									alert(da.info);
								}else{
									obj.html(obj.find('div input').val());
									}
							}
						
						});				
			});
		obj.find('.cancel').bind('click',function(){
			obj.find('div').remove();
			});

		});
	});
/***************************************提示信息*******************************************/
	/*************************/
(function(e){e.fn.mytab=function(t){var n=e(this).selector,r={ev:"mouseover",navcls:".kl-tab-nav",divcls:".kl-tab-div",navhovercls:"n1",divshowcls:"d1",showdiv:1,effect:"fade"},i=e.extend(r,t);e(n+" "+i.divcls).each(function(t,n){e(this).attr("markid",t)}),e(n+" "+i.navcls).each(function(t,n){e(this).attr("markid",t)}),e(n+" "+i.divcls).hide(),e(n+" "+i.navcls).bind(i.ev,function(){var t=e(this);t.parents(n).find(i.navcls).removeClass(i.navhovercls),t.addClass(i.navhovercls),t.parents(n).find(i.divcls).hide(),t.parents(n).find(i.divcls).removeClass(i.divshowcls),t.parents(n).find(i.navcls).each(function(r){if(e(this).attr("markid")==t.attr("markid")){t.parents(n).find(i.divcls).eq(r).addClass(i.divshowcls);var s=t.parents(n).find(i.divcls).eq(r);i.effect=="fade"?(s.css({opacity:"0",display:"block"}),s.animate({opacity:1},200)):s.show()}})}),e(n+" "+i.navcls+":first-child").trigger(i.ev)}})(jQuery);
//使用方法
//$('.a').mytab({				'ev':'mouseover',
//							'navcls':'.kl-tab-nav',//默认导航类
//							'divcls':'.kl-tab-div',//默认内容块
//                            'navhovercls':'n1',//nav显示时候拥有的类
//                            'divshowcls':'d1',//div显示的时候拥有的类
//                            'showdiv':1,
//});

/* 上传图片预览弹出层 */
$(function(){
	//批量操作按钮
	$('.btn-batch').bind('click',function(){
		var str='';
		$('input[name="ids[]"]:checked').each(function(index, element) {
            if(str==''){
				str=$(this).val();
				}else{
				str=str+','+$(this).val();	
					}
			
        });
		//提交数据
		var url=$(this).attr('url');
		$.ajax({
			  'type':'POST',
			  'url': url, 
			  'data':{id:str},
			  'success':function(da){
					topmsg(da);
				  },
			  dataType:'JSON'
			});
		});
    $(window).resize(function(){
        var winW = $(window).width();
        var winH = $(window).height();
        $(".upload-img-box").click(function(){
        	//如果没有图片则不显示
        	if($(this).find('img').attr('src') === undefined){
        		return false;
        	}
            // 创建弹出框以及获取弹出图片
            var imgPopup = "<div id=\"uploadPop\" class=\"upload-img-popup\"></div>"
            var imgItem = $(this).find(".upload-pre-item").html();

            //如果弹出层存在，则不能再弹出
            var popupLen = $(".upload-img-popup").length;
            if( popupLen < 1 ) {
                $(imgPopup).appendTo("body");
                $(".upload-img-popup").html(
                    imgItem + "<a class=\"close-pop\" href=\"javascript:;\" title=\"关闭\"></a>"
                );
            }

            // 弹出层定位
            var uploadImg = $("#uploadPop").find("img");
            var popW = uploadImg.width();
            var popH = uploadImg.height();
            var left = (winW -popW)/2;
            var top = (winH - popH)/2 + 50;
            $(".upload-img-popup").css({
                "max-width" : winW * 0.9,
                "left": left,
                "top": top
            });
        });

        // 关闭弹出层
        $("body").on("click", "#uploadPop .close-pop", function(){
            $(this).parent().remove();
        });
    }).resize();

    // 缩放图片
    function resizeImg(node,isSmall){
        if(!isSmall){
            $(node).height($(node).height()*1.2);
        } else {
            $(node).height($(node).height()*0.8);
        }
    }
})


	function ThinksetValue(name, value){
		var first = name.substr(0,1), input, i = 0, val;
		if(value === "") return;
		if("#" === first || "." === first){
			input = $(name);
		} else {
			input = $("[name='" + name + "']");
		}

		if(input.eq(0).is(":radio")) { //单选按钮
			input.filter("[value='" + value + "']").each(function(){this.checked = true});
		} else if(input.eq(0).is(":checkbox")) { //复选框
			if(!$.isArray(value)){
				val = new Array();
				val[0] = value;
			} else {
				val = value;
			}
			for(i = 0, len = val.length; i < len; i++){
				input.filter("[value='" + val[i] + "']").each(function(){this.checked = true});
			}
		} else {  //其他表单选项直接设置值
			input.val(value);
		}
	}
		$(function(){
	        //全选节点
	        $('.check-all').on('change',function(){
	            $('.ids').prop('checked',this.checked);
	        });
		});