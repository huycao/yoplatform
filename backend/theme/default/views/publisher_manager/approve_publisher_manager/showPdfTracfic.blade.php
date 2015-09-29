<html>
  <head>
    <title>Show Tracffic Report</title>    
    {{ HTML::script("{$assetURL}js/vendor/jquery-1.10.2.min.js") }}
    {{ HTML::script("{$assetURL}js/pdfobject/pdfobject.js") }}
    <script type="text/javascript">
      window.onload = function (){
        var showPDF = new PDFObject({ url: "{{$linkPdf}}" }).embed();
      };
    </script>
  </head>
 
  <body>
    <p>It appears you don't have Adobe Reader or PDF support in this web
    browser. <a href="{{$linkPdf}}">Click here to download the PDF</a></p>
  </body>
</html>

