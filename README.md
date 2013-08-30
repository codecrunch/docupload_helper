docupload_helper
================

CI helper to manage file uploading.

Creates an id folder at the supplied path if it does not exist, and checks if the extension is allowed.


Usage
-----

Copy the 'docupload_helper' to the helpers folder.

Add 'docupload' to the helpers array in config/autoload.php

`
docUpload($path, $id, $doctype = 'doc', $current = FALSE, $file = FALSE)
`

