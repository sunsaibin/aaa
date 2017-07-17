<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <title></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <META HTTP-EQUIV="pragma" CONTENT="no-cache">
    <META HTTP-EQUIV="Cache-Control" CONTENT="no-cache, must-revalidate">
    <META HTTP-EQUIV="expires" CONTENT="Wed, 26 Feb 1997 08:21:57 GMT">
    <META HTTP-EQUIV="expires" CONTENT="0">

    <base href="<?php echo base_url("");?>" />

    <link href="/jslibs/bootstrapform/css/lib/bootstrap.min.css" rel="stylesheet">
    <link href="/jslibs/bootstrapform/css/lib/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="/jslibs/bootstrapform/css/custom.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->


    <link rel="shortcut icon" href="/jslibs/bootstrapform/images/favicon.ico">
    <link rel="apple-touch-icon" href="/jslibs/bootstrapform/images/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/jslibs/bootstrapform/images/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/jslibs/bootstrapform/images/apple-touch-icon-114x114.png">
  </head>

  <body>
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="#">流程表单设计</a>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row clearfix">
        <!-- Building Form. -->
        <div class="span6">
          <div class="clearfix">
            <h2>新建表单</h2>
            <hr>
            <div id="build">
              <form id="target" class="form-horizontal">
              </form>
            </div>
          </div>
        </div>
        <!-- / Building Form. -->

        <!-- Components -->
        <div class="span6">
          <h2>表单功能(拖拉功能至新建表单)</h2>
          <hr>
          <div class="tabbable">
            <ul class="nav nav-tabs" id="formtabs">
              <!-- Tab nav -->
            </ul>
            <form class="form-horizontal" id="components">
              <fieldset>
                <div class="tab-content">
                  <!-- Tabs of snippets go here -->
                </div>
              </fieldset>
            </form>
          </div>
        </div>
        <!-- / Components -->

      </div>

    </div> <!-- /container -->

    <script data-main="/jslibs/bootstrapform/js/main.js" src="/jslibs/bootstrapform/js/lib/require.js" ></script>
  </body>
</html>
