# PhpAndElasticsearchTest

1. Create elastic account: https://www.elastic.co/
2. Run [composer_require.bat](ToolsWin%2Fcomposer_require.bat)
3. Retrieve from Elastic Cloud web UI 'cloud-id' and 'api-key': https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/connecting.html
4. Configure [.env](.env)
5. Download and extract for cacert.pem here (a clean file format/data): ttps://curl.haxx.se/docs/caextract.html
6. Put it in: C:\xampp\php\extras\ssl\cacert.pem
7. Add this line to your php.ini: curl.cainfo = "C:\xampp\php\extras\ssl\cacert.pem"
