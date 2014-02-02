function _Pagination_limit_change(_selectObj, offset, offsetId, limitId, submitFunc) {
	var offEle = document.getElementById(offsetId);
	offEle.value = offset;
	var limit = document.getElementById(limitId);
	limit.value = _selectObj.value;
	submitFunc();

}
// 分页标签使用
function _Pagination_NextPage(offset, offsetId, submitFunc) {

	var offEle = document.getElementById(offsetId);
	offEle.value = offset;
	// alert(submitFunc +":" + typeof(submitFunc) );
	submitFunc();
}

function _Pagination_JumpPage(allPage, limit, offsetId, submitFunc) {
	var jumppage = document.getElementById("_Pagination_jumppage").value;
	if (jumppage > allPage) {
		jumppage = allPage;
	}
	if (jumppage <= 0) {
		jumppage = 1;
	}
	var offset = (jumppage - 1) * limit;
	var frm = document.getElementById(frm);
	var offEle = document.getElementById(offsetId);
	offEle.value = offset;
	// alert(submitFunc +":" + typeof(submitFunc) );
	submitFunc();
}

//禁止连续点击提交按钮，连续点击按钮
var checkSubmitFlg = false;

function checkSubmit() {
	if (checkSubmitFlg == true) {

		return false;
	}
	checkSubmitFlg = true;
	return true;
}

/**
 * 通过Ajax提交Form数据
 * @param  {[type]} returnDataDivId [返回的数据所要显示的Div ID,如果successCallback非null,则本字段无效]
 * @param  {[type]} formId          [表单ID]
 * @param  {[type]} actionUrl       [请求地址]
 * @param  {[type]} successCallback [成功的回调地址]
 * @param  {[type]} errorCallback   [失败的回调地址]
 * @return {[type]}                 [无]
 */
function searchFormByAjax(returnDataDivId, formId, actionUrl, successCallback, errorCallback) {
	var form = document.getElementById(formId);
	var jqform = $('#' + formId);
	var m_data = jqform.serialize();

	if(!form.onsubmit || (form.onsubmit() != false)) {
		$.ajax({
			url: actionUrl,
			data: m_data,
			type: "POST",
			success: function(result) {
				if(successCallback != null) {
					eval(successCalback);
				} else {
					$("#" + returnDataDivId).html(result);
				}
				checkSubmitFlg = false;
			},
			error: function() {
				if(errorCallback != null) {
					eval(errorCallback);
				} else {
					$.scojs_message("出错了!", $.scojs_message.TYPE_ERROR);
				}
				checkSubmitFlg = false;
			}
		});
	}
}


//模态对话框请求数据时，滚动条的进度
window.progresslen = 0;
//定时更新模态对话框的滚动条
window.intervalId;

function changeProgressbar() {
	//alert(progresslen);
	window.parent.$("#modalprogress").attr({'style': 'width:'+progresslen+'%', 'aria-valuenow':progresslen});
	if(progresslen<90) {
		progresslen += 5;
	} else if(progresslen<99) {
		progresslen += 1;
	}
}

function stopProgressbar() {
	intervalId = window.clearInterval(intervalId);
	window.parent.$("#modalprogress").attr({'style': 'width:0%', 'aria-valuenow':'0'});
	progresslen = 0;
}

function getFormDataFromModalDialog(formId) {
	return window.parent.$("#" + formId).serialize();
}

var is_confirmed_unsave_form = false;
var confirm_lock = false;
var confirm_save = false;

/**
 * 生成模态对话框
 * @param  {[type]} modal_title     [模态对话框标题]
 * @param  {[type]} remoteUrl       [所要显示的数据的请求地址]
 * @param  {[type]} request_data    [如果remoteUrl不为空，为请求的数据；否则直接显示在模态对话框中]
 * @param  {[type]} modal_width     [框体宽度]
 * @param  {[type]} successCallBack [模态对话框右下角【确定】按钮的回调函数]
 * @param  {[type]} closeCallBack   [模态对话框关闭后的回调函数]
 * @return {[type]}                 [无]
 */
function genModalDialog(modal_title, remoteUrl, request_data, modal_width, successCallBack, successParam, closeCallBack, closeParam) {

	var modal_content = "正在获取数据..";

	//初始化模态对话框
	if(!window.parent.$("body").has("#myModal").length) {
		var modal_all_before = "<input type='button' style='display:none' id='modalbutton'/><div class='modal fade' id='myModal' style='margin-top:35px' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'><div class='modal-dialog'><div class='modal-content'>";
		var modal_header = "<div class='modal-header'><button id='closeModalBtn' type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button><h3 class='modal-title' id='myModalLabel'></h3></div>";
		var modal_body = "<div class='modal-body'></div>";
		var modal_footer = "<div class='modal-footer'><button id='cancleModalBtn' type='button' class='btn btn-default' data-dismiss='modal'>取消</button><button id='confirmModalBtn' type='button' class='btn btn-primary'>确定</button></div>";
		var modal_all_after = "</div></div></div>";
		window.parent.$("body").append(modal_all_before + modal_header + modal_body + modal_footer + modal_all_after);
		window.parent.$("#modalbutton").attr({"data-toggle":"modal", "data-backdrop":"static", "data-target":"#myModal"});
	}

	//[确定]按钮的点击事件
	if(successCallBack) {
		window.parent.$("#confirmModalBtn").attr("onclick", "callModalSuccessMethod('"+successCallBack+"',"+successParam+")");
	} else {
		window.parent.$("#confirmModalBtn").removeAttr("onclick");
	}
/*	//[取消]以及[x]按钮的点击事件
	if(closeCallBack) {
		window.parent.$("#cancleModalBtn").attr("onclick", "callModalCancelMethod('"+closeCallBack+"',"+closeParam+")");
		window.parent.$("#closeModalBtn").attr("onclick", "callModalCancelMethod('"+closeCallBack+"',"+closeParam+")");
	} else {
		window.parent.$("#cancleModalBtn").removeAttr("onclick");
		window.parent.$("#closeModalBtn").removeAttr("onclick");
	}*/
	window.parent.$("#cancleModalBtn").attr("onclick", "prepareCancelModal()");

	window.parent.$(".modal-dialog").css("width", modal_width);
	window.parent.$(".modal-title").html(modal_title);
	window.parent.$(".modal-body").html("<table width='100%'><tr><td style='text-align:center' id='myspin'><div class='progress progress-striped active'><div id='modalprogress' class='progress-bar' role='progressbar' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100' style='width:0%'><span class='sr-only'>Loading..</span></div></div></td></tr><tr><td style='text-align:center'>"+modal_content+"</td></tr></table>");
	window.parent.$("#modalbutton").click();

	var old_content;
	is_confirmed_unsave_form = false;
	confirm_lock = false;

	window.parent.$("#myModal").on("hide.bs.modal", function(e){
		var new_content = window.parent.$(".modal-body form").serialize();
		//alert("old:\n" + old_content + "\nnew:\n" + new_content);
/*		if(old_content == new_content || confirm("是否放弃修改?")) {
			if(closeCallBack) {
				callModalCancelMethod(closeCallBack,closeParam);
			}
			return true;
		} else {
			return false;
		}*/
		//取消模态框的时候，这个有时候会被回两三次调
		if(is_confirmed_unsave_form) {
			return true;
		} else {
			if(old_content == new_content || is_confirmed_unsave_form || confirm_lock || confirm_save || confirm("是否放弃修改?")) {
			//	alert("confirm:" + is_confirmed_unsave_form + " window.confirm_lock:" + window.confirm_lock);
			//	alert("confirm_save:" + confirm_save);
				if(!confirm_lock || confirm_save) {
					if(!confirm_save) is_confirmed_unsave_form = true;
					if(closeCallBack) {
						callModalCancelMethod(closeCallBack,closeParam);
					}
					return true;
				} else {
					return false;
				}
			} else {
			//	alert("window.confirm_lock:" + window.confirm_lock);
				confirm_lock = true;
				return false;
			}
		}
	});

	window.parent.$("#myModal").on("hidden.bs.modal", function(e){
		is_confirmed_unsave_form = false;
		confirm_lock = false;
		confirm_save = false;
	})

	//加载数据
	if(remoteUrl) {
		$.ajax({
			url: remoteUrl,
			data: request_data,
			type: "POST",
			global: false,
			beforeSend: function() {
				intervalId = setInterval("changeProgressbar()", 30);
			},
			success: function(result) {
				stopProgressbar();
		 		window.parent.$(".modal-body").html(result);
				old_content =  window.parent.$(".modal-body form").serialize();
			},
			error: function() {
				stopProgressbar();
				//window.parent.$(".modal-body").html("<table width='100%'><tr><td style='text-align:center'><strong><font color='red'>&lt;数据获取失败!&gt;</font></strong></td></tr></table>");
				window.parent.$(".modal-body").html("<p class='text-center'><strong><font color='red'>&lt;数据获取失败!&gt;</font></strong></p>");
			}
		});
	} else {
		old_content   = data;
		modal_content = data;
		window.parent.$(".modal-body").html(modal_content);
	}
}

function prepareCancelModal()
{
	var dom = window.document.getElementById('mainScreenFrm');
	if(dom.contentWindow) {
		dom.contentWindow.is_confirmed_unsave_form = false;
		dom.contentWindow.confirm_lock = false;
	} else {
		dom.contentDocument.is_confirmed_unsave_form = false;
		dom.contentDocument.confirm_lock = false;
	}
/*	alert("1|confirm:" + is_confirmed_unsave_form + " window.confirm_lock:" + window.document.getElementById('mainScreenFrm').contentWindow.confirm_lock);
	is_confirmed_unsave_form = false;
	window.document.getElementById('mainScreenFrm').contentWindow.confirm_lock = false;
	alert("2|confirm:" + is_confirmed_unsave_form + " window.confirm_lock:" + window.document.getElementById('mainScreenFrm').contentWindow.confirm_lock);
*/
}

function callModalSuccessMethod(successMethod, successParam)
{
	var dom = window.document.getElementById('mainScreenFrm');
	var successFunStr;
	if(dom.contentWindow) {
		dom.contentWindow.confirm_save = true;
		successFunStr = "window.document.getElementById('mainScreenFrm').contentWindow." + successMethod;
	} else {
		dom.contentDocument.confirm_save = true;
		successFunStr = "window.document.getElementById('mainScreenFrm').contentDocument." + successMethod;
	}
	var successFun = eval(successFunStr);
	var data = $(".modal-body form").serialize();
	successFun(data, successParam, window.document);
}

function callModalCancelMethod(closeMethod, closeParam)
{
	var dom = window.parent.document.getElementById('mainScreenFrm');
	var cancelFunStr
	if(dom.contentWindow) {
		cancelFunStr = "window.parent.document.getElementById('mainScreenFrm').contentWindow." + closeMethod;
	} else {
		cancelFunStr = "window.parent.document.getElementById('mainScreenFrm').contentDocument." + closeMethod;
	}
	var cancelFun = eval(cancelFunStr);
	cancelFun(closeParam, window.parent.document);
}