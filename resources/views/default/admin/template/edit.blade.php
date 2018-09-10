

        <div class="pb-bd">
            <div class="pb-ct">
                <div class="tishi">
                    <div class="tishi_info">
                        <p class="first">注意：1、弹出框鼠标移到头部可以拖动，以防笔记本小屏幕内容展示不全；</p>
                    </div>
                </div>
                <div class="tab">
                    <ul class="clearfix">
                        <li class="current">内容设置</li>
                    </ul>
                </div>
                <div class="modal-body">
                    <div class="body_info" id="banner_info">
                        <div class="ps_table ps-container">
                            <table id="addpictable" class="table">
                                <thead>
                                <tr>
                                    <th>图片</th>
                                    <th>图片链接</th>
                                    <th class="center">排序</th>
                                    <th class="center">操作</th>
                                </tr>
                                </thead>
                                <tbody class="imgInput" >
                                <tr>
                                    <td>
                                        <div  class="imgInput">
                                            <span><img src="http://localhost/new_source/data/gallery_album/2/original_img/1494984992503176615.jpg"></span>
                                            <input type="hidden" name="pic_src[]" value="http://localhost/new_source/data/gallery_album/2/original_img/1494984992503176615.jpg">
                                        </div>
                                    </td>
                                    <td>
                                        <input type="text" name="link[]" value="" class="form-control">
                                    </td>
                                    <td class="center">
                                        <input type="text" value="1" name="sort[]" class="form-control small">
                                    </td>
                                    <td class="center">
                                        <a href="javascript:;" class="pic_del del">删除</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="ps-scrollbar-x-rail" style="width: 918px; display: none; left: 0px; bottom: 3px;"><div class="ps-scrollbar-x" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; height: 108px; display: none; right: 0px;"><div class="ps-scrollbar-y" style="top: 0px; height: 0px;"></div></div></div>
                        <div class="images_space">
                            <div class="goods_gallery mt20" ectype="album-warp">
                                <div class="nav">
                                    <form action="" id="gallery_pic" method="post" enctype="multipart/form-data" runat="server">
                                        <div class="fl" ectype="albumFilter">
                                            <div class="imitate_select select_w220" id="album_id">
                                                <div class="cite">首页可视化</div>
                                                <ul style="display: none;" class="ps-container" ectype="album_list_check">
                                                    <li><a href="javascript:;" data-value="0" class="ftx-01">请选择...</a></li>
                                                    <li><a href="javascript:;" data-value="2" class="ftx-01">首页可视化</a></li>
                                                </ul>
                                                <input name="album_id" type="hidden" value="2" id="album_id_val">
                                            </div>
                                            <div class="imitate_select select_w220" id="sort_name">
                                                <div class="cite">按上传时间从晚到早</div>
                                                <ul style="display: none;" class="ps-container">
                                                    <li><a href="javascript:;" data-value="2" class="ftx-01">按上传时间从晚到早</a></li>
                                                    <li><a href="javascript:;" data-value="1" class="ftx-01">按上传时间从早到晚</a></li>
                                                    <li><a href="javascript:;" data-value="3" class="ftx-01">按图片从小到大</a></li>
                                                    <li><a href="javascript:;" data-value="4" class="ftx-01">按图片从大到小</a></li>
                                                    <li><a href="javascript:;" data-value="5" class="ftx-01">按图片名升序</a></li>
                                                    <li><a href="javascript:;" data-value="6" class="ftx-01">按图片名降序</a></li>
                                                </ul>
                                                <input name="sort_name" type="hidden" value="2" id="sort_name_val">
                                            </div>
                                        </div>
                                        <div class="updata_btn">
                                            <a href="javascript:void(0);" class="btn30 sc-btn red_btn">上传图片<input name="file" type="file"></a>
                                            <a href="javascript:void(0);" class="btn30 sc-btn red_btn" ectype="add_album">添加相册</a>
                                        </div>
                                    </form>
                                </div>

                                <div class="table_list ps-container ps-active-y" ectype="pic_list">
                                    <div class="gallery_album" data-act="get_albun_pic" data-inid="pic_list" data-url="get_ajax_content.php" data-where="sort_name=2&amp;album_id=2">
                                        <ul class="ga-images-ul">
                                            <li><a href="javascript:;" onclick="addpic('http://localhost/new_source/data/gallery_album/2/original_img/1495042209788792159.jpg',this)"><img src="http://localhost/new_source/data/gallery_album/2/original_img/1495042209788792159.jpg"><span class="pixel">232x280</span></a></li>
                                        </ul>
                                        <div class="clear"></div>
                                        <div class="pagination">
                                            <ul>
                                                <li><span>首页</span></li>
                                                <li><span>上一页</span></li>
                                                <li><span class="currentpage">1</span></li>
                                                <li><a class="demo" href="javascript:;" onclick="gallery_album_list_pb(this,'1','next')" style="min-height: 321px;"><span>下一页</span></a></li>
                                                <li><a class="demo" href="javascript:;" onclick="gallery_album_list_pb(this,'7')" style="min-height: 321px;"><span>末页</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="ps-scrollbar-x-rail" style="width: 918px; display: none; left: 0px; bottom: 3px;">
                                        <div class="ps-scrollbar-x" style="left: 0px; width: 0px;">
                                        </div>
                                    </div>
                                    <div class="ps-scrollbar-y-rail" style="top: 0px; height: 200px; display: inherit; right: 0px;">
                                        <div class="ps-scrollbar-y" style="top: 0px; height: 87px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="body_info" style="display:none;">
                        <div class="control_list">
                            <div class="control_item">
                                <div class="control_text"><em class="red">*</em>图片高度：</div>
                                <div class="control_value">
                                    <div class="fl mr10"><input type="text" name="picHeight" value="500" class="shop_text" ectype="required" data-msg="请在显示设置填写轮播图高度" autocomplete="off"><span>px</span></div>
                                    <div class="notic">请设置在300-500px这个之间</div>
                                </div>
                            </div>
                            <div class="control_item">
                                <div class="control_text">是否新窗口打开：</div>
                                <div class="control_value">
                                    <div class="checkbox_items">
                                        <div class="checkbox_item">
                                            <input type="radio" name="target" value="_blank" class="ui-radio" id="blank" checked="">
                                            <label class="ui-radio-label" for="blank">是</label>
                                        </div>
                                        <div class="checkbox_item">
                                            <input type="radio" name="target" value="_self" class="ui-radio" id="self">
                                            <label class="ui-radio-label" for="self">否</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="control_list hide">
                            <div class="control_item">
                                <div class="tit_head mb10">
                                    <div class="control_item">
                                        <div class="control_text">背景色：</div>
                                        <div class="control_value">
                                            <input type="text" name="navColor" class="navColor" value="#dbe0e4">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pb-ft">
                <a class="pb-btn pb-ok">确定</a>
            </div>
        </div>

        <script type="text/javascript">
            function addpic(){
                var src = $(this).attr("data_src");
                alert(src);
            }
        </script>
