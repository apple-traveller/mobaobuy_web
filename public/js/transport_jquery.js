/**
 * @file            transport_jquery.js
 * @description     用于支持AJAX的传输类。
**/

var Transport =
{
  /* *
  * 存储本对象所在的文件名。
  *
  * @static
  */
  filename : "transport_jquery.js",

  /* *
  * 存储是否进入调试模式的开关，打印调试消息的方式，换行符，调试用的容器的ID。
  *
  * @private
  */
  debugging :
  {
    isDebugging : 0,
    debuggingMode : 0,
    linefeed : "",
    containerId : 0
  },

  /* *
  * 传输完毕后自动调用的方法，优先级比用户从run()方法中传入的回调函数高。
  *
  * @public
  */
  onComplete : function ()
  {
  },

  /* *
  * 传输过程中自动调用的方法。
  *
  * @public
  */
  onRunning : function ()
  {
  },

  /* *
  * 调用此方法发送HTTP请求。
  *
  * @public
  * @param   {string}    url             请求的URL地址
  * @param   {mix}       params          发送参数
  * @param   {Function}  callback        回调函数
  * @param   {string}    ransferMode     请求的方式，有"GET"和"POST"两种
  * @param   {string}    responseType    响应类型，有"JSON"、"XML"和"TEXT"三种
  * @param   {boolean}   asyn            是否异步请求的方式
  * @param   {boolean}   quiet           是否安静模式请求
  */
  run : function (url, params, callback, transferMode, responseType)
  {
      $.ajax({
          url:url,
          type: transferMode,
          dataType: responseType,
          data: params,
          success:callback
      });
  },

    file : function (url, params, callback)
    {
        $.ajax({
            url:url,
            type: "post",
            data: params,
            success:callback,
            processData: false,
            contentType: false,
        });
    },
};

/* 定义两个别名 */
var Ajax = Transport;

Ajax.call = Transport.run;
Ajax.file = Transport.file;
