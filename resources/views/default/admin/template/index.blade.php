@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="warpper">
        <div class="title">模板 - 首页可视化管理</div>
        <div class="content">
            <div class="explanation" id="explanation" style="width: 1070px;">
                <div class="ex_tit" style="margin-bottom: 10px;"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示" class=""></span></div>
                <ul style="display: block;">
                    <li>展示所有首页模板。</li>
                    <li>可进行首页模板信息，内容等编辑</li>
                    <li>每套模板有对应的首页模板</li>
                    <li>该功能暂时只支持ecmoban_dsc2017，ecmoban_dsc后期开发中，敬请期待</li>
                    <li>导出时需选中对应的选中按钮</li>
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-head">
                    <div class="fl">
                        <a href="javascript:void(0);" ectype="information" data-code=""><div class="fbutton"><div class="add" title="添加新模板"><span><i class="icon icon-plus"></i>添加新模板</span></div></div></a>
                        <a href="javascript:void(0);" ectype="export"><div class="fbutton"><div class="add" title="导出"><span><i class="icon icon-download-alt"></i>导出</span></div></div></a>
                    </div>
                </div>
                <div class="common-content">
                    <div class="common-content">
                        <div class="mian-info">
                            <form method="post" action="visualhome.php?act=export_tem" name="listForm" id="exportForm">
                                <div class="list-div" id="listDiv">
                                    <div class="template-list template-ksh-list mt10" ectype="templateList">
                                        <ul>
                                            <li class="curr">
                                                <div class="checkbox_item">
                                                    <input name="checkboxes[]" value="backup_tpl_1" class="ui-checkbox" id="checkbox_backup_tpl_1" type="checkbox">
                                                    <label for="checkbox_backup_tpl_1" class="ui-label"></label>
                                                </div>
                                                <div class="tit" title="首页默认可视化模板">首页默认可视化模板</div>
                                                <div class="span"></div>
                                                <div class="img" ectype="setupTemplate" data-code="backup_tpl_1" data-id="1">
                                                <img src="{{asset(themePath('/').'images/screenshot.png')}}" data-src-wide="" id="backup_tpl_1" ectype="pic" class="pic" width="263" height="338" border="0">
                                                    <div class="bg"></div>
                                                </div>

                                                <div class="box" ectype="setupTemplate" data-code="backup_tpl_1" data-id="1">
                                                    <i class="icon icon-gou"></i>
                                                    <span>使用该模版</span>
                                                </div>
                                                <div class="info">
                                                    <div class="row">
                                                        <a href="" target="_blank" ectype="see" class="mr10">查看大图</a>
                                                        <a href="/template/decorate" target="_blank">装修</a>
                                                    </div>
                                                    <div class="row">
                                                        <a href="" class="mr10" target="_blank">预览模板</a>
                                                        <a href="javascript:void(0);" ectype="information" data-code="backup_tpl_1" data-id="1" class="mr10">编辑模板信息</a>
                                                        <a href="javascript:removeTemplate('backup_tpl_1','1')">删除模板</a>
                                                    </div>
                                                </div>
                                               {{-- <i class="ing" ectype="default"></i>--}}
                                            </li>
                                        </ul>
                                        <input name="template_type" value="" type="hidden">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
