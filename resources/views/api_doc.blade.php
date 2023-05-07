<!-- HTML for static distribution bundle build -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>API Documentation | {{ config('app.name') }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('api-docs-assets/swagger-ui.css') }}"/>
    <link rel="icon" type="image/png" href="{{ storagelink(config('settings.site_favicon')) }}" sizes="32x32"/>
    <link rel="icon" type="image/png" href="{{ storagelink(config('settings.site_favicon')) }}" sizes="16x16"/>
    <style>
        html {
            box-sizing: border-box;
            overflow: -moz-scrollbars-vertical;
            overflow-y: scroll;
        }

        *,
        *:before,
        *:after {
            box-sizing: inherit;
        }

        body {
            margin: 0;
            background: #fafafa;
        }
    </style>
</head>

<body>
<div id="swagger-ui"></div>

<script src="{{ asset('api-docs-assets/swagger-ui-bundle.js') }}" charset="UTF-8"></script>
<script src="{{ asset('api-docs-assets/swagger-ui-standalone-preset.js') }}" charset="UTF-8"></script>
<script>
    window.onload = function () {
        // Begin Swagger UI call region
        const ui = SwaggerUIBundle({
            url         : "{{ asset('api-docs-assets/swagger.json') }}",
            dom_id      : '#swagger-ui',
            validatorUrl: null,
            deepLinking : true,
            presets     : [
                SwaggerUIBundle.presets.apis,
                SwaggerUIStandalonePreset
            ],
            plugins     : [
                SwaggerUIBundle.plugins.DownloadUrl
            ],
            layout      : "StandaloneLayout"
        });
        // End Swagger UI call region

        window.ui = ui;
    };
</script>
</body>
</html>
