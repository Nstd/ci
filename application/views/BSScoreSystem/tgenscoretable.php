<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF8" />
		<title><?php echo $title; ?></title>
		<?php echo $cssjscontent; ?>
	</head>
	<script type="text/javascript">
		var maxRow = 1;
		//35是右侧二级指标输入框的高度
		var secodeIndexInputHeight = 35;

		$(document).ready(function(){
			//增加二级项目
			$("td[class^='add2-']").live('click', function(){
				var rowClassName = $(this).attr("class");
				var rowId = rowClassName.substring(rowClassName.indexOf("-")+1);
				var headTr = $(document).find("tr.row-" + rowId + "-title");
				var headTd = $(headTr).find("td.myheadcol");
				$(headTd).attr("rowspan", parseInt($(headTd).attr("rowspan"))+1);
				var rowNum = $("tr.row-" + rowId + "-1").length;
				var firstRowNameInput = $(headTr).find(".first-name");
				var firstRowRationInput = $(headTr).find(".first-ratio");
				$(firstRowNameInput).css("height", ((parseInt(rowNum)+2)*secodeIndexInputHeight)+"px");
				$(firstRowRationInput).css("height", ((parseInt(rowNum)+2)*secodeIndexInputHeight)+"px");

				var rowhtml = getSecondRowItem(rowId);

				$(rowhtml).insertBefore($(this).parent());
			});

			//删除二级项目
			$(".remove-col").live('click',function(){
				var parentTr = $(this).parent().parent().parent();
				var parentTrClassName = $(parentTr).attr("class");
				var rowIdName = parentTrClassName.substring(0, parentTrClassName.lastIndexOf('-'));
				var rowId = rowIdName.substring(rowIdName.lastIndexOf('-')+1);
				var rowNum = $("tr.row-" + rowId + "-1").length;

				if(rowNum == 1) {
					genErrorMessage("这是当前一级指标下的最后一个二级指标，不能删除!");
					return false;
				}

				var headTr = $("tr." + rowIdName + "-title");
				var firstRowNameInput = $(headTr).find(".first-name");
				var firstRowRationInput = $(headTr).find(".first-ratio");
				var headtd = $(headTr).find("td.myheadcol");
				$(headtd).attr("rowspan", parseInt($(headtd).attr("rowspan"))-1);
				$(this).parent().parent().parent().remove();
				$(firstRowNameInput).css("height", ((parseInt(rowNum))*secodeIndexInputHeight)+"px");
				$(firstRowRationInput).css("height", ((parseInt(rowNum))*secodeIndexInputHeight)+"px");
			});

			//增加一级项目
			$("td[class^='add1']").click(function(){
				maxRow++;
				var newtrhtml = getFirstRowItem(maxRow);
				$(newtrhtml).insertBefore($(this).parent());

			});

			//删除一级项目
			$(".remove-row").live('click',function(){
				var rowClass = $(this).parent().parent().parent().attr("class");
				var rowId = rowClass.substring(rowClass.indexOf("-")+1, rowClass.lastIndexOf("-"));
				$("tr[class^='row-" + rowId + "'").remove();
			
			});


			//限制在[权重]输入框中只能输入数字
			$(".first-ratio").live('keydown', function(event){
				var code = event.keyCode;
				if(!((code>=48 && code <=57) || code==8)){
					event.preventDefault();
				}
			})

			$(".second-ratio").live('keydown', function(){
				var code = event.keyCode;
				if(!((code>=48 && code <=57) || code==8)){
					event.preventDefault();
				}
			})

			//显示剩余权重
			$(".first-ratio").live('keyup', function(event){
				var ratios = getFirstItemRatio();
				$("#remainScore").html("剩余权重:&nbsp;" + (100-parseInt(ratios)));
			})

			$(".second-ratio").live('keyup', function(event){
				var ratios = getSecondItemRatio(this);
				$("#remainScore").html("剩余权重:&nbsp;" + (100-parseInt(ratios)));
			})

			$("input[class*='-ratio']").live('blur', function(){
				$("#remainScore").html("");
			})

			$(".first-ratio").live('focus', function(){
				var ratios = getFirstItemRatio();
				$("#remainScore").html("剩余权重:&nbsp;" + (100-parseInt(ratios)));
			})


			$(".second-ratio").live('focus', function(){
				var ratios = getSecondItemRatio(this);
				$("#remainScore").html("剩余权重:&nbsp;" + (100-parseInt(ratios)));
			})
			
		});

		function getFirstRowItem(rowid) {
			var rowhtml = "\
				<tr class='row-"+rowid+"-title'>\
					<td class='myheadcol' rowspan='3' style='padding:0px 0px 0px 0px;vertical-align:middle;'>\
						<div class='input-group' style='height:100%'>\
							<input type='text' class='first-name form-control' style='width:80%;height:72px' placeholder='一级指标'>\
							<input type='text' class='first-ratio form-control' style='width:20%;height:72px' placeholder='权重'>\
							<span class='remove-row input-group-addon'><span class='glyphicon glyphicon-remove'></span></span>\
						</div>\
					</td>\
				</tr>" + getSecondRowItem(rowid) + "<tr class='row-"+rowid+"-add'>\
					<td style='text-align:center;' class='add2-"+rowid+"'><span class='glyphicon glyphicon-plus-sign'></span>\
					</td>\
				</tr>";
			return rowhtml;
		}

		function getSecondRowItem(rowid) {
			var rowhtml = "\
				<tr class='row-"+rowid+"-1'>\
					<td style='padding:0px 0px 0px 0px;vertical-align:middle;'>\
					<div class='input-group' style='display:in-line;width:100%;'>\
						<input type='text' class='second-name form-control' style='width:80%;' placeholder='二级指标'>\
						<input type='text' class='second-ratio form-control' style='width:20%;' placeholder='权重'>\
						<span class='remove-col input-group-addon'><span class='glyphicon glyphicon-remove'></span></span>\
					</div>\
					</td>\
				</tr>"
			return rowhtml;
		}

		//待提交的数据
		var data = [];
		//提交评分表
		function submitScoreItem() {
			//参数检查
			//检查一级权重
			if(getFirstItemRatio() != 100) {
				genErrorMessage("一级权重之和不为100，请检查!");
				$(".first-ratio:first").focus();
				return ;
			}

			//检查二级权重
			var not_pass_check = false;
			$("tr[class^='row-'][class$='-1']").each(function(){
				if(!not_pass_check) {
					var class_name = $(this).attr("class");
					var ratio = getSecondItemRatio(this);
					if(ratio !== 100) {
						not_pass_check = true;
						$(this).find(".second-ratio:first").focus();
					}
				}
			});

			if(not_pass_check) {
				genErrorMessage("某二级权重之和不为100，请检查!");
				return ;
			}

			//检查是否有空的输入框
			$("input").each(function(){
				if(!not_pass_check && $(this).val().replace(/(^\s*)|(\s*$)/g, "") == "") {
					not_pass_check = true;
					$(this).focus();
				}
			})

			if(not_pass_check) {
				genErrorMessage("输入框不能为空!");
				return ;
			}
			
			var sdata = "";
			$("tr[class^='row-'][class$='-title'").each(function(){
				var rowClassName = $(this).attr('class');
				var rowId = rowClassName.substring(rowClassName.indexOf("-")+1, rowClassName.lastIndexOf("-"));
				data[rowId] = new Array();
				data[rowId][0] = new Array();
				data[rowId][0][0] = $(this).find(".first-name").val();
				data[rowId][0][1] = $(this).find(".first-ratio").val();

				sdata += "data[" + rowId + "][0][0]=" + $(this).find(".first-name").val() + "&";
				sdata += "data[" + rowId + "][0][1]=" + $(this).find(".first-ratio").val() + "&";

				var num = 1;
				$("tr[class='row-" + rowId + "-1']").each(function(){
					data[rowId][num] = new Array();
					data[rowId][num][0] = $(this).find(".second-name").val();
					data[rowId][num][1] = $(this).find(".second-ratio").val();

					sdata += "data[" + rowId + "][" + num + "][0]=" + $(this).find(".second-name").val() + "&";
					sdata += "data[" + rowId + "][" + num + "][1]=" + $(this).find(".second-ratio").val() + "&";

					num++;
				})
			});

			sdata += (new Date().getTime());
			
			$.post(
				'<?php echo "$site_url/$site_name/teacher/t_add_score_item" ?>', 
				sdata, 
				function(result){
					if(result == "success") {
						genSuccessMessage("评分表保存成功!");
						$('#savebtn').hide();
						$("tr[class$='row-'][class$='-add'] tr").html("&nbsp").removeClass('row');
					}
					else if(result == "exist") {
						genErrorMessage("评分表已存在!");
						$('#savebtn').hide();
					}
					else if(result == "error") {
						genErrorMessage("系统错误!");
					}
					else {
						genErrorMessage("未知错误!");
					}
				}
			);
		}

		function getFirstItemRatio() {
			var ratio = 0;
			$("tr[class^='row-'][class$='-title']").each(function(){
				var reg = /^\d+$/g;
				var m_ratio =$(this).find(".first-ratio").val();
				if(reg.test(m_ratio)){
					ratio += parseInt(m_ratio);
				}
			});
			return ratio;
		}

		function getSecondItemRatio(_element) {
			var ratio = 0;
			var tr_class_name = "";
			var is_input = $(_element).is("input");
			if(is_input){
				tr_class_name = $(_element).parent().parent().parent().attr("class");
			} else {
				tr_class_name = $(_element).attr("class");
			}
			$("." + tr_class_name).each(function(){
				var reg = /^\d+$/g;
				var m_ratio = $(this).find(".second-ratio").val();
				if(reg.test(m_ratio))
					ratio += parseInt(m_ratio);
			});

			return ratio;
		}

		function genErrorMessage(msg) {
			$.scojs_message(msg, $.scojs_message.TYPE_ERROR);
		}

		function genSuccessMessage(msg) {
			$.scojs_message(msg, $.scojs_message.TYPE_OK);
		}

		function genModalConfirm(msg) {
			$(".modal-body").html("<p>" + msg + "</p>");
			$("#myModal").modal({
				backdrop: 'static'
			});
		}

	</script>
	<body>
		<?php echo $theader; ?>
		<div class="container" style="width:80%">
			<div class="row">
				<div class="col-sm-12">
					<?php echo $scoretable; ?>
				</div>
			</div>
		</div>

		<div class="modal fade" id="myModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		 				<h4 class="modal-title">通知</h4>
					</div>
					<div class="modal-body">
						<p></p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
						<button type="button" onclick="" class="btn btn-primary" data-dismiss="modal">确定</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</body>
</html>