@extends(themePath('.')."admin.include.layouts.master")
@section('iframe')
    <div class="content">
        <div class="tabs_info">
            <ul>
                <li class="curr">
                    <a href="users.php?act=list">会员列表</a>
                </li>
                <li>
                    <a href="user_rank.php?act=list">会员等级</a>
                </li>
                <li>
                    <a href="user_real.php?act=list">实名认证</a>
                </li>
                <li>
                    <a href="reg_fields.php?act=list">注册项设置</a>
                </li>
            </ul>
        </div>        	<div class="explanation" id="explanation" style="width: 100px;">
            <div class="ex_tit" style="margin-bottom: 0px;"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="提示相关设置操作时应注意的要点" class="shopUp"></span></div>
            <ul style="display: none;">
                <li>会员列表展示商城所有的会员信息。</li>
                <li>可通过会员名称关键字进行搜索，如需详细搜索请在侧边栏进行高级搜索。</li>
                <li>会员等级必须在有效积分范围内，否则无法显示会员等级；<em>比如会员积分0，却没有0积分的等级就会显示无等级</em></li>
            </ul>
        </div>
        <div class="flexilist">
            <div class="common-head">
                <div class="fl">
                    <a href="javascript:download_userlist();"><div class="fbutton"><div class="csv" title="导出会员列表"><span><i class="icon icon-download-alt"></i>导出会员列表</span></div></div></a>
                    <a href="users.php?act=add"><div class="fbutton"><div class="add" title="添加会员"><span><i class="icon icon-plus"></i>添加会员</span></div></div></a>
                </div>

                <div class="refresh">
                    <div class="refresh_tit" title="刷新数据"><i class="icon icon-refresh"></i></div>
                    <div class="refresh_span">刷新 - 共15条记录</div>
                </div>

                <div class="search">
                    <form action="javascript:;" name="searchForm" onsubmit="searchGoodsname(this);">
                        <div class="input">
                            <input type="text" name="keywords" class="text nofocus" placeholder="会员名称" autocomplete="off">
                            <input type="submit" class="btn" name="secrch_btn" ectype="secrch_btn" value="">
                        </div>
                    </form>
                </div>

            </div>
            <div class="common-content">
                <form method="POST" action="" name="listForm" onsubmit="return confirm_bath()">
                    <div class="list-div" id="listDiv">
                        <table cellpadding="0" cellspacing="0" border="0">
                            <thead>
                            <tr>
                                <th width="3%" class="sign"><div class="tDiv"><input type="checkbox" name="all_list" class="checkbox" id="all_list"><label for="all_list" class="checkbox_stars"></label></div></th>
                                <th width="5%"><div class="tDiv"><a href="javascript:listTable.sort('user_id'); ">编号</a><img src="/default/images/sort_desc.gif"></div></th>
                                <th width="10%"><div class="tDiv"><a href="javascript:listTable.sort('user_name'); ">会员名称</a></div></th>
                                <th width="10%"><div class="tDiv">昵称</div></th>
                                <th width="8%"><div class="tDiv">商家名称</div></th>
                                <th width="8%"><div class="tDiv">手机/邮箱</div></th>
                                <th width="8%"><div class="tDiv">注册日期</div></th>
                                <th width="8%"><div class="tDiv">账户</div></th>
                                <th width="6%"><div class="tDiv">等级积分</div></th>
                                <th width="6%"><div class="tDiv">验证</div></th>
                                <th width="12%" class="handle">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="tr_bg_blue">
                                <td class="sign"><div class="tDiv"><input type="checkbox" name="checkboxes[]" value="18" class="checkbox" id="checkbox_18"><label for="checkbox_18" class="checkbox_stars"></label></div></td>
                                <td><div class="tDiv">18</div></td>
                                <td><div class="tDiv">商家10</div></td>
                                <td><div class="tDiv"></div></td>
                                <td><div class="tDiv"><font class="red">Swisse专卖店</font></div></td>
                                <td><div class="tDiv">未验证手机<br>124984758@qq.com</div></td>
                                <td><div class="tDiv">2017-03-23</div></td>
                                <td>
                                    <div class="tDiv">
                                        <p>可用资金：0.00</p>
                                        <p>消费积分：0</p>
                                    </div>
                                </td>
                                <td><div class="tDiv">0<br>铜牌会员</div></td>
                                <td>
                                    <div class="tDiv">
                                        <div class="switch " title="否" onclick="listTable.switchBt(this, 'toggle_is_validated', 18)">
                                            <div class="circle"></div>
                                        </div>
                                        <input type="hidden" value="0" name="">
                                    </div>
                                </td>
                                <td class="handle">
                                    <div class="tDiv a2">
                                        <a href="users.php?act=edit&amp;id=18" class="btn_see"><i class="sc_icon sc_icon_see"></i>查看</a>
                                        <a href="users.php?act=users_log&amp;id=18" class="btn_see"><i class="sc_icon sc_icon_see"></i>日志</a>
                                        <a href="javascript:confirm_redirect('您确定要删除该会员账号吗？', 'users.php?act=remove&amp;id=18')" title="移除" class="btn_trash"><i class="icon icon-trash"></i>删除</a>
                                    </div>
                                </td>
                            </tr>
                            <tr class="">
                                <td class="sign"><div class="tDiv"><input type="checkbox" name="checkboxes[]" value="16" class="checkbox" id="checkbox_16"><label for="checkbox_16" class="checkbox_stars"></label></div></td>
                                <td><div class="tDiv">16</div></td>
                                <td><div class="tDiv">商家8</div></td>
                                <td><div class="tDiv">17884050-546635</div></td>
                                <td><div class="tDiv"><font class="red">迪卡侬专卖店</font></div></td>
                                <td><div class="tDiv">13165785219<br>未验证邮箱</div></td>
                                <td><div class="tDiv">2017-03-23</div></td>
                                <td>
                                    <div class="tDiv">
                                        <p>可用资金：0.00</p>
                                        <p>消费积分：0</p>
                                    </div>
                                </td>
                                <td><div class="tDiv">0<br>铜牌会员</div></td>
                                <td>
                                    <div class="tDiv">
                                        <div class="switch " title="否" onclick="listTable.switchBt(this, 'toggle_is_validated', 16)">
                                            <div class="circle"></div>
                                        </div>
                                        <input type="hidden" value="0" name="">
                                    </div>
                                </td>
                                <td class="handle">
                                    <div class="tDiv a2">
                                        <a href="users.php?act=edit&amp;id=16" class="btn_see"><i class="sc_icon sc_icon_see"></i>查看</a>
                                        <a href="users.php?act=users_log&amp;id=16" class="btn_see"><i class="sc_icon sc_icon_see"></i>日志</a>
                                        <a href="javascript:confirm_redirect('您确定要删除该会员账号吗？', 'users.php?act=remove&amp;id=16')" title="移除" class="btn_trash"><i class="icon icon-trash"></i>删除</a>
                                    </div>
                                </td>
                            </tr>
                            <tr class="">
                                <td class="sign"><div class="tDiv"><input type="checkbox" name="checkboxes[]" value="15" class="checkbox" id="checkbox_15"><label for="checkbox_15" class="checkbox_stars"></label></div></td>
                                <td><div class="tDiv">15</div></td>
                                <td><div class="tDiv">商家7</div></td>
                                <td><div class="tDiv">77836458-950794</div></td>
                                <td><div class="tDiv"><font class="red">七匹狼旗舰店</font></div></td>
                                <td><div class="tDiv">13122568795<br>未验证邮箱</div></td>
                                <td><div class="tDiv">2017-03-23</div></td>
                                <td>
                                    <div class="tDiv">
                                        <p>可用资金：0.00</p>
                                        <p>消费积分：0</p>
                                    </div>
                                </td>
                                <td><div class="tDiv">0<br>铜牌会员</div></td>
                                <td>
                                    <div class="tDiv">
                                        <div class="switch " title="否" onclick="listTable.switchBt(this, 'toggle_is_validated', 15)">
                                            <div class="circle"></div>
                                        </div>
                                        <input type="hidden" value="0" name="">
                                    </div>
                                </td>
                                <td class="handle">
                                    <div class="tDiv a2">
                                        <a href="users.php?act=edit&amp;id=15" class="btn_see"><i class="sc_icon sc_icon_see"></i>查看</a>
                                        <a href="users.php?act=users_log&amp;id=15" class="btn_see"><i class="sc_icon sc_icon_see"></i>日志</a>
                                        <a href="javascript:confirm_redirect('您确定要删除该会员账号吗？', 'users.php?act=remove&amp;id=15')" title="移除" class="btn_trash"><i class="icon icon-trash"></i>删除</a>
                                    </div>
                                </td>
                            </tr>
                            <tr class="">
                                <td class="sign"><div class="tDiv"><input type="checkbox" name="checkboxes[]" value="14" class="checkbox" id="checkbox_14"><label for="checkbox_14" class="checkbox_stars"></label></div></td>
                                <td><div class="tDiv">14</div></td>
                                <td><div class="tDiv">商家6</div></td>
                                <td><div class="tDiv">6578618-678041</div></td>
                                <td><div class="tDiv"><font class="red">周大福旗舰店</font></div></td>
                                <td><div class="tDiv">13655211895<br>未验证邮箱</div></td>
                                <td><div class="tDiv">2017-03-23</div></td>
                                <td>
                                    <div class="tDiv">
                                        <p>可用资金：0.00</p>
                                        <p>消费积分：0</p>
                                    </div>
                                </td>
                                <td><div class="tDiv">0<br>铜牌会员</div></td>
                                <td>
                                    <div class="tDiv">
                                        <div class="switch " title="否" onclick="listTable.switchBt(this, 'toggle_is_validated', 14)">
                                            <div class="circle"></div>
                                        </div>
                                        <input type="hidden" value="0" name="">
                                    </div>
                                </td>
                                <td class="handle">
                                    <div class="tDiv a2">
                                        <a href="users.php?act=edit&amp;id=14" class="btn_see"><i class="sc_icon sc_icon_see"></i>查看</a>
                                        <a href="users.php?act=users_log&amp;id=14" class="btn_see"><i class="sc_icon sc_icon_see"></i>日志</a>
                                        <a href="javascript:confirm_redirect('您确定要删除该会员账号吗？', 'users.php?act=remove&amp;id=14')" title="移除" class="btn_trash"><i class="icon icon-trash"></i>删除</a>
                                    </div>
                                </td>
                            </tr>
                            <tr class="">
                                <td class="sign"><div class="tDiv"><input type="checkbox" name="checkboxes[]" value="13" class="checkbox" id="checkbox_13"><label for="checkbox_13" class="checkbox_stars"></label></div></td>
                                <td><div class="tDiv">13</div></td>
                                <td><div class="tDiv">商家5</div></td>
                                <td><div class="tDiv">79109877-722636</div></td>
                                <td><div class="tDiv"><font class="red">当当旗舰店旗舰店</font></div></td>
                                <td><div class="tDiv">17155521168<br>未验证邮箱</div></td>
                                <td><div class="tDiv">2017-03-23</div></td>
                                <td>
                                    <div class="tDiv">
                                        <p>可用资金：0.00</p>
                                        <p>消费积分：0</p>
                                    </div>
                                </td>
                                <td><div class="tDiv">0<br>铜牌会员</div></td>
                                <td>
                                    <div class="tDiv">
                                        <div class="switch " title="否" onclick="listTable.switchBt(this, 'toggle_is_validated', 13)">
                                            <div class="circle"></div>
                                        </div>
                                        <input type="hidden" value="0" name="">
                                    </div>
                                </td>
                                <td class="handle">
                                    <div class="tDiv a2">
                                        <a href="users.php?act=edit&amp;id=13" class="btn_see"><i class="sc_icon sc_icon_see"></i>查看</a>
                                        <a href="users.php?act=users_log&amp;id=13" class="btn_see"><i class="sc_icon sc_icon_see"></i>日志</a>
                                        <a href="javascript:confirm_redirect('您确定要删除该会员账号吗？', 'users.php?act=remove&amp;id=13')" title="移除" class="btn_trash"><i class="icon icon-trash"></i>删除</a>
                                    </div>
                                </td>
                            </tr>
                            <tr class="">
                                <td class="sign"><div class="tDiv"><input type="checkbox" name="checkboxes[]" value="12" class="checkbox" id="checkbox_12"><label for="checkbox_12" class="checkbox_stars"></label></div></td>
                                <td><div class="tDiv">12</div></td>
                                <td><div class="tDiv">商家4</div></td>
                                <td><div class="tDiv">41889595-994242</div></td>
                                <td><div class="tDiv"><font class="red">大众专卖店</font></div></td>
                                <td><div class="tDiv">13788556622<br>未验证邮箱</div></td>
                                <td><div class="tDiv">2017-03-23</div></td>
                                <td>
                                    <div class="tDiv">
                                        <p>可用资金：0.00</p>
                                        <p>消费积分：0</p>
                                    </div>
                                </td>
                                <td><div class="tDiv">0<br>铜牌会员</div></td>
                                <td>
                                    <div class="tDiv">
                                        <div class="switch " title="否" onclick="listTable.switchBt(this, 'toggle_is_validated', 12)">
                                            <div class="circle"></div>
                                        </div>
                                        <input type="hidden" value="0" name="">
                                    </div>
                                </td>
                                <td class="handle">
                                    <div class="tDiv a2">
                                        <a href="users.php?act=edit&amp;id=12" class="btn_see"><i class="sc_icon sc_icon_see"></i>查看</a>
                                        <a href="users.php?act=users_log&amp;id=12" class="btn_see"><i class="sc_icon sc_icon_see"></i>日志</a>
                                        <a href="javascript:confirm_redirect('您确定要删除该会员账号吗？', 'users.php?act=remove&amp;id=12')" title="移除" class="btn_trash"><i class="icon icon-trash"></i>删除</a>
                                    </div>
                                </td>
                            </tr>
                            <tr class="">
                                <td class="sign"><div class="tDiv"><input type="checkbox" name="checkboxes[]" value="11" class="checkbox" id="checkbox_11"><label for="checkbox_11" class="checkbox_stars"></label></div></td>
                                <td><div class="tDiv">11</div></td>
                                <td><div class="tDiv">商家3</div></td>
                                <td><div class="tDiv">61146276-892367</div></td>
                                <td><div class="tDiv"><font class="red">多秒屋</font></div></td>
                                <td><div class="tDiv">13877776666<br>未验证邮箱</div></td>
                                <td><div class="tDiv">2017-03-23</div></td>
                                <td>
                                    <div class="tDiv">
                                        <p>可用资金：0.00</p>
                                        <p>消费积分：0</p>
                                    </div>
                                </td>
                                <td><div class="tDiv">0<br>铜牌会员</div></td>
                                <td>
                                    <div class="tDiv">
                                        <div class="switch " title="否" onclick="listTable.switchBt(this, 'toggle_is_validated', 11)">
                                            <div class="circle"></div>
                                        </div>
                                        <input type="hidden" value="0" name="">
                                    </div>
                                </td>
                                <td class="handle">
                                    <div class="tDiv a2">
                                        <a href="users.php?act=edit&amp;id=11" class="btn_see"><i class="sc_icon sc_icon_see"></i>查看</a>
                                        <a href="users.php?act=users_log&amp;id=11" class="btn_see"><i class="sc_icon sc_icon_see"></i>日志</a>
                                        <a href="javascript:confirm_redirect('您确定要删除该会员账号吗？', 'users.php?act=remove&amp;id=11')" title="移除" class="btn_trash"><i class="icon icon-trash"></i>删除</a>
                                    </div>
                                </td>
                            </tr>
                            <tr class="">
                                <td class="sign"><div class="tDiv"><input type="checkbox" name="checkboxes[]" value="10" class="checkbox" id="checkbox_10"><label for="checkbox_10" class="checkbox_stars"></label></div></td>
                                <td><div class="tDiv">10</div></td>
                                <td><div class="tDiv">商家2</div></td>
                                <td><div class="tDiv">9514366-769664</div></td>
                                <td><div class="tDiv"><font class="red">成人旗舰店</font></div></td>
                                <td><div class="tDiv">15888886666<br>未验证邮箱</div></td>
                                <td><div class="tDiv">2017-03-23</div></td>
                                <td>
                                    <div class="tDiv">
                                        <p>可用资金：0.00</p>
                                        <p>消费积分：0</p>
                                    </div>
                                </td>
                                <td><div class="tDiv">0<br>铜牌会员</div></td>
                                <td>
                                    <div class="tDiv">
                                        <div class="switch " title="否" onclick="listTable.switchBt(this, 'toggle_is_validated', 10)">
                                            <div class="circle"></div>
                                        </div>
                                        <input type="hidden" value="0" name="">
                                    </div>
                                </td>
                                <td class="handle">
                                    <div class="tDiv a2">
                                        <a href="users.php?act=edit&amp;id=10" class="btn_see"><i class="sc_icon sc_icon_see"></i>查看</a>
                                        <a href="users.php?act=users_log&amp;id=10" class="btn_see"><i class="sc_icon sc_icon_see"></i>日志</a>
                                        <a href="javascript:confirm_redirect('您确定要删除该会员账号吗？', 'users.php?act=remove&amp;id=10')" title="移除" class="btn_trash"><i class="icon icon-trash"></i>删除</a>
                                    </div>
                                </td>
                            </tr>
                            <tr class="">
                                <td class="sign"><div class="tDiv"><input type="checkbox" name="checkboxes[]" value="9" class="checkbox" id="checkbox_9"><label for="checkbox_9" class="checkbox_stars"></label></div></td>
                                <td><div class="tDiv">9</div></td>
                                <td><div class="tDiv">商家1</div></td>
                                <td><div class="tDiv">74603925-582879</div></td>
                                <td><div class="tDiv"><font class="red">美宝莲</font></div></td>
                                <td><div class="tDiv">15988883666<br>未验证邮箱</div></td>
                                <td><div class="tDiv">2017-03-23</div></td>
                                <td>
                                    <div class="tDiv">
                                        <p>可用资金：0.00</p>
                                        <p>消费积分：0</p>
                                    </div>
                                </td>
                                <td><div class="tDiv">0<br>铜牌会员</div></td>
                                <td>
                                    <div class="tDiv">
                                        <div class="switch " title="否" onclick="listTable.switchBt(this, 'toggle_is_validated', 9)">
                                            <div class="circle"></div>
                                        </div>
                                        <input type="hidden" value="0" name="">
                                    </div>
                                </td>
                                <td class="handle">
                                    <div class="tDiv a2">
                                        <a href="users.php?act=edit&amp;id=9" class="btn_see"><i class="sc_icon sc_icon_see"></i>查看</a>
                                        <a href="users.php?act=users_log&amp;id=9" class="btn_see"><i class="sc_icon sc_icon_see"></i>日志</a>
                                        <a href="javascript:confirm_redirect('您确定要删除该会员账号吗？', 'users.php?act=remove&amp;id=9')" title="移除" class="btn_trash"><i class="icon icon-trash"></i>删除</a>
                                    </div>
                                </td>
                            </tr>
                            <tr class="">
                                <td class="sign"><div class="tDiv"><input type="checkbox" name="checkboxes[]" value="6" class="checkbox" id="checkbox_6"><label for="checkbox_6" class="checkbox_stars"></label></div></td>
                                <td><div class="tDiv">6</div></td>
                                <td><div class="tDiv">服装</div></td>
                                <td><div class="tDiv"></div></td>
                                <td><div class="tDiv"><font class="red">服装专卖店</font></div></td>
                                <td><div class="tDiv">未验证手机<br>13253452@qq.com</div></td>
                                <td><div class="tDiv">2017-03-22</div></td>
                                <td>
                                    <div class="tDiv">
                                        <p>可用资金：0.00</p>
                                        <p>消费积分：0</p>
                                    </div>
                                </td>
                                <td><div class="tDiv">0<br>铜牌会员</div></td>
                                <td>
                                    <div class="tDiv">
                                        <div class="switch " title="否" onclick="listTable.switchBt(this, 'toggle_is_validated', 6)">
                                            <div class="circle"></div>
                                        </div>
                                        <input type="hidden" value="0" name="">
                                    </div>
                                </td>
                                <td class="handle">
                                    <div class="tDiv a2">
                                        <a href="users.php?act=edit&amp;id=6" class="btn_see"><i class="sc_icon sc_icon_see"></i>查看</a>
                                        <a href="users.php?act=users_log&amp;id=6" class="btn_see"><i class="sc_icon sc_icon_see"></i>日志</a>
                                        <a href="javascript:confirm_redirect('您确定要删除该会员账号吗？', 'users.php?act=remove&amp;id=6')" title="移除" class="btn_trash"><i class="icon icon-trash"></i>删除</a>
                                    </div>
                                </td>
                            </tr>
                            <tr class="">
                                <td class="sign"><div class="tDiv"><input type="checkbox" name="checkboxes[]" value="5" class="checkbox" id="checkbox_5"><label for="checkbox_5" class="checkbox_stars"></label></div></td>
                                <td><div class="tDiv">5</div></td>
                                <td><div class="tDiv">三只松鼠</div></td>
                                <td><div class="tDiv">59988587-477113</div></td>
                                <td><div class="tDiv"><font class="red">三只松鼠</font></div></td>
                                <td><div class="tDiv">未验证手机<br>11324353@qq.com</div></td>
                                <td><div class="tDiv">2017-03-22</div></td>
                                <td>
                                    <div class="tDiv">
                                        <p>可用资金：0.00</p>
                                        <p>消费积分：0</p>
                                    </div>
                                </td>
                                <td><div class="tDiv">0<br>铜牌会员</div></td>
                                <td>
                                    <div class="tDiv">
                                        <div class="switch " title="否" onclick="listTable.switchBt(this, 'toggle_is_validated', 5)">
                                            <div class="circle"></div>
                                        </div>
                                        <input type="hidden" value="0" name="">
                                    </div>
                                </td>
                                <td class="handle">
                                    <div class="tDiv a2">
                                        <a href="users.php?act=edit&amp;id=5" class="btn_see"><i class="sc_icon sc_icon_see"></i>查看</a>
                                        <a href="users.php?act=users_log&amp;id=5" class="btn_see"><i class="sc_icon sc_icon_see"></i>日志</a>
                                        <a href="javascript:confirm_redirect('您确定要删除该会员账号吗？', 'users.php?act=remove&amp;id=5')" title="移除" class="btn_trash"><i class="icon icon-trash"></i>删除</a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="sign"><div class="tDiv"><input type="checkbox" name="checkboxes[]" value="4" class="checkbox" id="checkbox_4"><label for="checkbox_4" class="checkbox_stars"></label></div></td>
                                <td><div class="tDiv">4</div></td>
                                <td><div class="tDiv">全友家私</div></td>
                                <td><div class="tDiv">99374148-222227</div></td>
                                <td><div class="tDiv"><font class="red">全友家私</font></div></td>
                                <td><div class="tDiv">未验证手机<br>12455@qq.com</div></td>
                                <td><div class="tDiv">2017-03-22</div></td>
                                <td>
                                    <div class="tDiv">
                                        <p>可用资金：0.00</p>
                                        <p>消费积分：0</p>
                                    </div>
                                </td>
                                <td><div class="tDiv">0<br>铜牌会员</div></td>
                                <td>
                                    <div class="tDiv">
                                        <div class="switch " title="否" onclick="listTable.switchBt(this, 'toggle_is_validated', 4)">
                                            <div class="circle"></div>
                                        </div>
                                        <input type="hidden" value="0" name="">
                                    </div>
                                </td>
                                <td class="handle">
                                    <div class="tDiv a2">
                                        <a href="users.php?act=edit&amp;id=4" class="btn_see"><i class="sc_icon sc_icon_see"></i>查看</a>
                                        <a href="users.php?act=users_log&amp;id=4" class="btn_see"><i class="sc_icon sc_icon_see"></i>日志</a>
                                        <a href="javascript:confirm_redirect('您确定要删除该会员账号吗？', 'users.php?act=remove&amp;id=4')" title="移除" class="btn_trash"><i class="icon icon-trash"></i>删除</a>
                                    </div>
                                </td>
                            </tr>
                            <tr class="">
                                <td class="sign"><div class="tDiv"><input type="checkbox" name="checkboxes[]" value="3" class="checkbox" id="checkbox_3"><label for="checkbox_3" class="checkbox_stars"></label></div></td>
                                <td><div class="tDiv">3</div></td>
                                <td><div class="tDiv">火影</div></td>
                                <td><div class="tDiv">30571365-100204</div></td>
                                <td><div class="tDiv"><font class="red">火影旗舰店</font></div></td>
                                <td><div class="tDiv">未验证手机<br>125848@qq.com</div></td>
                                <td><div class="tDiv">2017-03-22</div></td>
                                <td>
                                    <div class="tDiv">
                                        <p>可用资金：0.00</p>
                                        <p>消费积分：0</p>
                                    </div>
                                </td>
                                <td><div class="tDiv">0<br>铜牌会员</div></td>
                                <td>
                                    <div class="tDiv">
                                        <div class="switch " title="否" onclick="listTable.switchBt(this, 'toggle_is_validated', 3)">
                                            <div class="circle"></div>
                                        </div>
                                        <input type="hidden" value="0" name="">
                                    </div>
                                </td>
                                <td class="handle">
                                    <div class="tDiv a2">
                                        <a href="users.php?act=edit&amp;id=3" class="btn_see"><i class="sc_icon sc_icon_see"></i>查看</a>
                                        <a href="users.php?act=users_log&amp;id=3" class="btn_see"><i class="sc_icon sc_icon_see"></i>日志</a>
                                        <a href="javascript:confirm_redirect('您确定要删除该会员账号吗？', 'users.php?act=remove&amp;id=3')" title="移除" class="btn_trash"><i class="icon icon-trash"></i>删除</a>
                                    </div>
                                </td>
                            </tr>
                            <tr class="">
                                <td class="sign"><div class="tDiv"><input type="checkbox" name="checkboxes[]" value="2" class="checkbox" id="checkbox_2"><label for="checkbox_2" class="checkbox_stars"></label></div></td>
                                <td><div class="tDiv">2</div></td>
                                <td><div class="tDiv">绿联</div></td>
                                <td><div class="tDiv">70789862-586557</div></td>
                                <td><div class="tDiv"><font class="red">绿联专卖店</font></div></td>
                                <td><div class="tDiv">未验证手机<br>123548@qq.com</div></td>
                                <td><div class="tDiv">2017-03-22</div></td>
                                <td>
                                    <div class="tDiv">
                                        <p>可用资金：0.00</p>
                                        <p>消费积分：0</p>
                                    </div>
                                </td>
                                <td><div class="tDiv">0<br>铜牌会员</div></td>
                                <td>
                                    <div class="tDiv">
                                        <div class="switch " title="否" onclick="listTable.switchBt(this, 'toggle_is_validated', 2)">
                                            <div class="circle"></div>
                                        </div>
                                        <input type="hidden" value="0" name="">
                                    </div>
                                </td>
                                <td class="handle">
                                    <div class="tDiv a2">
                                        <a href="users.php?act=edit&amp;id=2" class="btn_see"><i class="sc_icon sc_icon_see"></i>查看</a>
                                        <a href="users.php?act=users_log&amp;id=2" class="btn_see"><i class="sc_icon sc_icon_see"></i>日志</a>
                                        <a href="javascript:confirm_redirect('您确定要删除该会员账号吗？', 'users.php?act=remove&amp;id=2')" title="移除" class="btn_trash"><i class="icon icon-trash"></i>删除</a>
                                    </div>
                                </td>
                            </tr>
                            <tr class="">
                                <td class="sign"><div class="tDiv"><input type="checkbox" name="checkboxes[]" value="1" class="checkbox" id="checkbox_1"><label for="checkbox_1" class="checkbox_stars"></label></div></td>
                                <td><div class="tDiv">1</div></td>
                                <td><div class="tDiv">ecmoban</div></td>
                                <td><div class="tDiv">68908066-892245</div></td>
                                <td><div class="tDiv"><font class="red">万卓旗舰店</font></div></td>
                                <td><div class="tDiv">未验证手机<br>123542@qq.com</div></td>
                                <td><div class="tDiv">2017-03-22</div></td>
                                <td>
                                    <div class="tDiv">
                                        <p>可用资金：0.00</p>
                                        <p>消费积分：997</p>
                                    </div>
                                </td>
                                <td><div class="tDiv">1000<br>铜牌会员</div></td>
                                <td>
                                    <div class="tDiv">
                                        <div class="switch " title="否" onclick="listTable.switchBt(this, 'toggle_is_validated', 1)">
                                            <div class="circle"></div>
                                        </div>
                                        <input type="hidden" value="0" name="">
                                    </div>
                                </td>
                                <td class="handle">
                                    <div class="tDiv a2">
                                        <a href="users.php?act=edit&amp;id=1" class="btn_see"><i class="sc_icon sc_icon_see"></i>查看</a>
                                        <a href="users.php?act=users_log&amp;id=1" class="btn_see"><i class="sc_icon sc_icon_see"></i>日志</a>
                                        <a href="javascript:confirm_redirect('您确定要删除该会员账号吗？', 'users.php?act=remove&amp;id=1')" title="移除" class="btn_trash"><i class="icon icon-trash"></i>删除</a>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="12">
                                    <div class="tDiv">
                                        <div class="tfoot_btninfo">
                                            <input type="hidden" name="act" value="batch_remove">
                                            <input type="submit" value="删除" name="remove" ectype="btnSubmit" class="btn btn_disabled" disabled="disabled">
                                        </div>
                                        <div class="list-page">
                                            <!-- $Id: page.lbi 14216 2008-03-10 02:27:21Z testyang $ -->

                                            <div id="turn-page">
                                                <span class="page page_1">总计 <em id="totalRecords">15</em>个记录</span>
                                                <span class="page page_2">分为<em id="totalPages">1</em>页</span>
                                                <!--<span>页当前第<em id="pageCurrent">1</em></span>-->
                                                <span class="page page_3"><i>每页</i><input type="text" size="3" id="pageSize" value="15" onkeypress="return listTable.changePageSize(event)"></span>
                                                <span class="page mr10"><i>至</i><input type="text" size="3" value="1" onkeypress="listTable.gotoPage($(this).val())"></span>
                                                <span id="page-link">
        <a href="javascript:listTable.gotoPageFirst()" class="first" title="第一页"></a>
        <a href="javascript:listTable.gotoPagePrev()" class="prev" title="上一页"></a>
        <select id="gotoPage" onchange="listTable.gotoPage(this.value)">
            <option value="1">1</option>        </select>
        <a href="javascript:listTable.gotoPageNext()" class="next" title="下一页"></a>
        <a href="javascript:listTable.gotoPageLast()" class="last" title="最末页"></a>
    </span>
                                            </div>


                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </form>
            </div>
        </div>

        <div class="gj_search">
            <div class="search-gao-list" id="searchBarOpen">
                <i class="icon icon-zoom-in"></i>高级搜索                </div>
            <div class="search-gao-bar">
                <div class="handle-btn" id="searchBarClose"><i class="icon icon-zoom-out"></i>收起边栏</div>
                <div class="title"><h3>高级搜索</h3></div>
                <form method="get" name="formSearch_senior" action="javascript:searchUser()">
                    <div class="searchContent">
                        <div class="layout-box">
                            <dl>
                                <dt>会员/昵称</dt>
                                <dd><input type="text" value="" name="keyword" class="s-input-txt" autocomplete="off"></dd>
                            </dl>
                            <dl>
                                <dt>会员积分</dt>
                                <dd><input type="text" value="" name="pay_points_lt" class="s-input-txt-2" autocomplete="off"><div class="bool">&nbsp;&nbsp;~&nbsp;&nbsp;</div><input type="text" value="" name="pay_points_gt" class="s-input-txt-2"></dd>
                            </dl>
                            <dl>
                                <dt>手机</dt>
                                <dd><input type="text" value="" name="mobile_phone" class="s-input-txt" autocomplete="off"></dd>
                            </dl>
                            <dl>
                                <dt>邮件地址</dt>
                                <dd><input type="text" value="" name="email" class="s-input-txt" autocomplete="off"></dd>
                            </dl>
                            <dl>
                                <dt>会员等级</dt>
                                <dd>
                                    <div class="select_w145 imitate_select">
                                        <div class="cite">所有等级</div>
                                        <ul style="display: none;">
                                            <li><a href="javascript:;" data-value="0">所有等级</a></li>
                                            <li><a href="javascript:;" data-value="6">铜牌</a></li>
                                            <li><a href="javascript:;" data-value="7">银牌</a></li>
                                            <li><a href="javascript:;" data-value="8">金牌</a></li>
                                            <li><a href="javascript:;" data-value="3">代销用户</a></li>
                                        </ul>
                                        <input name="user_rank" type="hidden" value="0">
                                    </div>
                                </dd>
                            </dl>
                            <dl>
                                <dt>店铺名称</dt>
                                <dd>
                                    <div id="shop_name_select" class="select_w145 imitate_select">
                                        <div class="cite">请选择...</div>
                                        <ul style="display: none;">
                                            <li><a href="javascript:;" data-value="0">请选择...</a></li>
                                            <li><a href="javascript:;" data-value="1">按店铺名称</a></li>
                                            <li><a href="javascript:;" data-value="2">按期望店铺名称</a></li>
                                            <li><a href="javascript:;" data-value="3">按入驻品牌+类型</a></li>
                                        </ul>
                                        <input name="store_search" type="hidden" value="0" id="shop_name_val">
                                    </div>
                                </dd>
                            </dl>
                            <dl style="display:none" id="merchant_box">
                                <dd>
                                    <div class="select_w145 imitate_select">
                                        <div class="cite">请选择</div>
                                        <ul style="display: none;">
                                            <li><a href="javascript:;" data-value="0">请选择</a></li>
                                            <li><a href="javascript:;" data-value="1">万卓旗舰店</a></li>
                                            <li><a href="javascript:;" data-value="2">绿联专卖店</a></li>
                                            <li><a href="javascript:;" data-value="3">火影旗舰店</a></li>
                                            <li><a href="javascript:;" data-value="4">全友家私</a></li>
                                            <li><a href="javascript:;" data-value="5">三只松鼠</a></li>
                                            <li><a href="javascript:;" data-value="6">服装专卖店</a></li>
                                            <li><a href="javascript:;" data-value="9">美宝莲</a></li>
                                            <li><a href="javascript:;" data-value="10">成人旗舰店</a></li>
                                            <li><a href="javascript:;" data-value="11">多秒屋</a></li>
                                            <li><a href="javascript:;" data-value="12">大众专卖店</a></li>
                                            <li><a href="javascript:;" data-value="13">当当旗舰店旗舰店</a></li>
                                            <li><a href="javascript:;" data-value="14">周大福旗舰店</a></li>
                                            <li><a href="javascript:;" data-value="15">七匹狼旗舰店</a></li>
                                            <li><a href="javascript:;" data-value="16">迪卡侬专卖店</a></li>
                                            <li><a href="javascript:;" data-value="18">Swisse专卖店</a></li>
                                        </ul>
                                        <input name="merchant_id" type="hidden" value="0">
                                    </div>
                                </dd>
                            </dl>
                            <dl id="store_keyword" style="display:none">
                                <dd><input type="text" value="" name="store_keyword" class="s-input-txt" autocomplete="off"></dd>
                            </dl>
                            <dl style="display:none" id="store_type">
                                <dd>
                                    <div class="select_w145 imitate_select">
                                        <div class="cite">店铺类型</div>
                                        <ul style="display: none;">
                                            <li><a href="javascript:;" data-value="0">店铺类型</a></li>
                                            <li><a href="javascript:;" data-value="旗舰店">旗舰店</a></li>
                                            <li><a href="javascript:;" data-value="专卖店">专卖店</a></li>
                                            <li><a href="javascript:;" data-value="专营店">专营店</a></li>
                                            <li><a href="javascript:;" data-value="馆">馆</a></li>
                                        </ul>
                                        <input name="store_type" type="hidden" value="0">
                                    </div>
                                </dd>
                            </dl>
                            <dl class="bot_btn">
                                <dd>
                                    <input type="submit" class="btn red_btn" name="tj_search" value="提交查询"><input type="reset" class="btn btn_reset" name="reset" value="重置">
                                </dd>
                            </dl>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@stop
