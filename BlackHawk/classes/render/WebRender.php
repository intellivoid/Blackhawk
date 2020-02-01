<?php
/**
 * BlackHawk Engine
 *
 * BlackHawk: WebRender.php
 *
 *
 * Created: 2/1/20, 12:25 PM
 * Last modified: 1/31/20, 8:14 PM
 * Modified by: intellivoid/antiengineer
 *
 * @copyright 2020 (C) Nighthawk Media Group
 * @author Diederik Noordhuis, Zi Xing Narrakas
 *
 * For more information, contact diederikn@intellivoid.info.
 * No modifications allowed. Distribution is prohibited.
 *
 */

namespace BlackHawk\classes\render;


use BlackHawk\classes\Utilities;
use BlackHawk\exceptions\runtime\RenderException;
use BlackHawk\objects\Configuration;
use BlackHawk\objects\Render;
use BlackHawk\objects\RouteHandler;

class WebRender
{
    /**
     * This function provides basic headers to the request.
     *
     * @param Configuration $cfg
     */
    public static function load(Configuration $cfg) {
        header("X-Powered-By: BlackHawk/".str_replace("v", "", $cfg->get("version")));
        header("X-Request-ID: ".Utilities::createUUID());
        header("X-BlackHawk-DeviceSecureCertify: ".Utilities::createDeviceFingerprint());
    }

    /**
     * This function renders a view according to the properties given
     *
     * @param Render $render
     * @param string $view
     * @param array $Properties
     * @param string $type
     */
    public static function renderView(Render $render, string $view, array $Properties, string $type) {
        $latte = new \Latte\Engine;
        $latte->setTempDirectory(sys_get_temp_dir());
        if(!file_exists($view)) {
            throw new RenderException("The view file '$view' does not exist in the system.");
        }
        $out = $latte->renderToString($view, $Properties);
        $render->props[$type] = $render->props[$type].$out;
        return;
    }

    /**
     * Overrides checks and loads a handler.
     *
     * @param RouteHandler $routeHandler
     * @param Configuration $cfg
     * @param array $IPStackData
     * @param array $Params
     */
    public static function loadHandler(RouteHandler $routeHandler, Configuration $cfg, array $IPStackData, array $Params = []) {
        self::load($cfg);
        $routeHandler->processRequest($Params, $IPStackData);
    }

    public static function staticResponse(string $title, string $code, string $error, string $info, bool $escapeHtml = false){
        ?>
        <!DOCTYPE HTML PUBLIC "-//IETF//DTD HTML 2.0//EN">
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
            <meta charset="utf-8">
            <meta http-equiv="x-ua-compatible" content="ie=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <title>
                <?PHP HTMLUtils::print($title);?>
            </title>
            <style>
                html {
                    overflow-y: scroll;
                    color: #f5f5f5;
                    font: 400 62.5%/1.4 Roboto, sans-serif;
                    -webkit-text-size-adjust: 100%;
                    -ms-text-size-adjust: 100%;
                    -webkit-tap-highlight-color: transparent
                }

                body,
                html {
                    height: 100%;
                    min-height: 100%
                }

                body {
                    margin: 0;
                    font-size: 1.3rem;
                    background: #212121;
                    color: #f5f5f5;
                    font-family: Roboto, sans-serif
                }

                a {
                    cursor: pointer;
                    text-decoration: none;
                    color: #d32f2f;
                    background-color: transparent
                }

                a:active,
                a:hover {
                    text-decoration: underline;
                    color: #d32f2f;
                    outline: 0
                }

                h1,
                h2 {
                    margin: 0 0 .5rem;
                    color: #f5f5f5;
                    font-weight: 400;
                    line-height: 1.5
                }

                h1 {
                    font-size: 2.4rem
                }

                h2 {
                    font-size: 3.6rem
                }

                .error-code {
                    color: #d32f2f;
                    font-size: 8rem;
                    line-height: 1
                }

                p {
                    margin: 1.2rem 0
                }

                p.lead {
                    font-size: 1.6rem;
                    color: #c2c2c2
                }

                hr {
                    box-sizing: content-box;
                    height: 0;
                    margin: 2.4rem 0;
                    border: 0;
                    border-top: 1px solid #ddd
                }

                .page {
                    display: -webkit-box;
                    display: -ms-flexbox;
                    display: flex;
                    min-height: 100vh
                }

                .page:before {
                    display: block;
                    content: '';
                    -webkit-box-flex: 0;
                    -ms-flex: 0 1 474px;
                    flex: 0 1 474px;
                    background: #484848 url(data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMjgiIGhlaWdodD0iNjkyIiB2aWV3Qm94PSIwIDAgMjI3LjYgNjkxLjgiPjxwYXRoIGQ9Ik02My41IDU2Ny4xaDEwMnYxMDguNGgtMTAyVjU2Ny4xeiIgZmlsbD0iI0ZGRiIvPjxwYXRoIGQ9Ik0xMTQuNyA1NjcuM2g1MHYxMDguNGgtNTBWNTY3LjN6IiBmaWxsPSIjODU4QzkzIi8+PHBhdGggZD0iTTYuMSAyOTAuOWgyMTYuNmMxLjcgMCAzIDEuMyAzIDN2MzQ0LjdjMCAxLjctMS4zIDMtMyAzSDYuMWMtMS43IDAtMy0xLjMtMy0zVjI5My45QzMuMSAyOTIuMiA0LjUgMjkwLjkgNi4xIDI5MC45eiIgZmlsbD0iIzIzQTdERSIvPjxwYXRoIGQ9Ik0xMTYuMiAyOTAuOWgxMDhjMC44IDAgMS41IDEuMyAxLjUgM3YzNDQuN2MwIDEuNy0wLjcgMy0xLjUgM0gxMTYuMmMtMC44IDAtMS41LTEuMy0xLjUtM1YyOTMuOUMxMTQuNyAyOTIuMiAxMTUuNCAyOTAuOSAxMTYuMiAyOTAuOXoiIGZpbGw9IiMxQThFQ0MiLz48cGF0aCBkPSJNMjI1LjcgNjM5LjVMMjI1LjcgNjM5LjVjMCAxMi4zLTkuMyAyMi4yLTIwLjggMjIuMkgyMy45Yy0xMS41IDAtMjAuOC05LjktMjAuOC0yMi4ybDAgMCIgZmlsbD0iIzJCQzFGRiIvPjxwYXRoIGQ9Ik0xMTQuNyA2MzkuNXYyMi4yaDkwLjJjMTEuNSAwIDIwLjgtOS45IDIwLjgtMjIuMkgxMTQuN3oiIGZpbGw9IiMyMEE0RUEiLz48cGF0aCBkPSJNMTc5LjEgNjExLjloMzQuNnYxNC44aC0zNC42VjYxMS45eiIgZmlsbD0iIzZBRkYwNyIvPjxwYXRoIGQ9Ik0xMC44IDY3My45SDIxOC44YzMuOSAwIDcgMy4xIDcgNi45IDAgMy44LTMuMSA2LjktNyA2LjlIMTAuOGMtMy44IDAtNy0zLjEtNy02LjlDMy44IDY3NyA2LjkgNjczLjkgMTAuOCA2NzMuOXoiIGZpbGw9IiNFQkVFRjAiLz48cGF0aCBkPSJNMjE4LjggNjczLjlIMTE0Ljd2MTMuOUgyMTguOGMzLjkgMCA3LTMuMSA3LTYuOUMyMjUuOCA2NzcgMjIyLjcgNjczLjkgMjE4LjggNjczLjl6IiBmaWxsPSIjQTJBN0FDIi8+PHBhdGggZD0iTTIyMi43IDI4OC45SDYuMWMtMS43IDAtMyAxLjMtMyAzdjRjMC0xLjcgMS4zLTMgMy0zaDIxNi42YzEuNyAwIDMgMS4zIDMgM3YtNEMyMjUuNyAyOTAuMiAyMjQuNCAyODguOSAyMjIuNyAyODguOXoiIGZpbGw9IiNBNUU0RjYiLz48cGF0aCBkPSJNMy4xIDQ1NC4xaDIyMi42djcuNEgzLjFWNDU0LjF6IiBmaWxsPSIjMjA5OUQwIi8+PHBhdGggZD0iTTMuMSA0NTIuMWgyMjIuNnY3LjRIMy4xVjQ1Mi4xeiIgZmlsbD0iIzFDRDdGRiIvPjxwYXRoIGQ9Ik0xMTQuNyA0NTQuMWgxMTF2Ny40SDExNC43VjQ1NC4xeiIgZmlsbD0iIzE4ODJCRiIvPjxwYXRoIGQ9Ik0xMTQuNyA0NTIuMWgxMTF2Ny40SDExNC43VjQ1Mi4xeiIgZmlsbD0iIzE0QjdFQSIvPjxwYXRoIGQ9Ik0zLjEgNDQ0LjdoNzYuMXYxNC44SDMuMVY0NDQuN3oiIGZpbGw9IiM3MUU5RkYiLz48cGF0aCBkPSJNMy4xIDQyNC4xaDIyMi42djcuNEgzLjFWNDI0LjF6IiBmaWxsPSIjMjA5OUQwIi8+PHBhdGggZD0iTTMuMSA0MjIuMWgyMjIuNnY3LjRIMy4xVjQyMi4xeiIgZmlsbD0iIzFDRDdGRiIvPjxwYXRoIGQ9Ik0xMTQuNyA0MjQuMWgxMTF2Ny40SDExNC43VjQyNC4xeiIgZmlsbD0iIzE4ODJCRiIvPjxwYXRoIGQ9Ik0xMTQuNyA0MjIuMWgxMTF2Ny40SDExNC43VjQyMi4xeiIgZmlsbD0iIzE0QjdFQSIvPjxwYXRoIGQ9Ik0zLjEgNDE0LjdoNzYuMXYxNC44SDMuMVY0MTQuN3oiIGZpbGw9IiM3MUU5RkYiLz48cGF0aCBkPSJNMy4xIDM5NC4xaDIyMi42djcuNEgzLjFWMzk0LjF6IiBmaWxsPSIjMjA5OUQwIi8+PHBhdGggZD0iTTMuMSAzOTIuMWgyMjIuNnY3LjRIMy4xVjM5Mi4xeiIgZmlsbD0iIzFDRDdGRiIvPjxwYXRoIGQ9Ik0xMTQuNyAzOTQuMWgxMTF2Ny40SDExNC43VjM5NC4xeiIgZmlsbD0iIzE4ODJCRiIvPjxwYXRoIGQ9Ik0xMTQuNyAzOTIuMWgxMTF2Ny40SDExNC43VjM5Mi4xeiIgZmlsbD0iIzE0QjdFQSIvPjxwYXRoIGQ9Ik0zLjEgMzg0LjdoNzYuMXYxNC44SDMuMVYzODQuN3oiIGZpbGw9IiM3MUU5RkYiLz48cGF0aCBkPSJNMy4xIDM2NC4xaDIyMi42djcuNEgzLjFWMzY0LjF6IiBmaWxsPSIjMjA5OUQwIi8+PHBhdGggZD0iTTMuMSAzNjIuMWgyMjIuNnY3LjRIMy4xVjM2Mi4xeiIgZmlsbD0iIzFDRDdGRiIvPjxwYXRoIGQ9Ik0xMTQuNyAzNjQuMWgxMTF2Ny40SDExNC43VjM2NC4xeiIgZmlsbD0iIzE4ODJCRiIvPjxwYXRoIGQ9Ik0xMTQuNyAzNjIuMWgxMTF2Ny40SDExNC43VjM2Mi4xeiIgZmlsbD0iIzE0QjdFQSIvPjxwYXRoIGQ9Ik0zLjEgMzU0LjdoNzYuMXYxNC44SDMuMVYzNTQuN3oiIGZpbGw9IiM3MUU5RkYiLz48bGluZWFyR3JhZGllbnQgaWQ9IlNWR0lEXzFfIiBncmFkaWVudFVuaXRzPSJ1c2VyU3BhY2VPblVzZSIgeDE9IjExMy44IiB5MT0iNC43IiB4Mj0iMTEzLjgiIHkyPSIxNjUuMSI+PHN0b3Agb2Zmc2V0PSIwIiBzdG9wLWNvbG9yPSIjRDFFREZGIi8+PHN0b3Agb2Zmc2V0PSIxIiBzdG9wLWNvbG9yPSIjQTVFM0ZFIi8+PC9saW5lYXJHcmFkaWVudD48cGF0aCBkPSJNNTguNSAxMS42Yy0xNC40IDkuNS0zMC45IDI3LjctMjQuNiA1OS44QzE0LjQgNzYuOCAwIDk0LjQgMCAxMTUuNmMwIDI1LjMgMjAuMyA0NS44IDQ1LjQgNDUuOGgxMzYuOGMyNS4xIDAgNDUuNC0yMC41IDQ1LjQtNDUuOCAwLTIwLjktMTIuNi0zNy42LTMyLjgtNDMuOSAxLjctOS40IDAuOS0yNS43LTE0LjUtMzcgLTguNi02LjMtMjYuNi0xMi4yLTQ0IDEuNEMxMTUuNi01LjQgNzMuNSAxLjcgNTguNSAxMS42eiIgZmlsbD0idXJsKCNTVkdJRF8xXykiLz48cGF0aCBkPSJNMTk0LjggNzQuN2MxOS42IDYuMiAzMi4xIDIyLjIgMzIuOCA0Mi4yIDAtMC40IDAtMC45IDAtMS4zIDAtMjAuNy0xMi41LTM3LjMtMzIuNC00My44QzE5NS4xIDcyLjggMTk1IDczLjggMTk0LjggNzQuN3oiIGZpbGw9IiNFM0Y0RkYiLz48cGF0aCBkPSJNNTguNSAxNC42QzczLjUgNC43IDExNS42LTIuNCAxMzYuNCAzOWMxNy40LTEzLjYgMzUuNC03LjcgNDQtMS4zIDExLjMgOC4zIDE0LjggMTkuMyAxNS4xIDI4LjMgMC40LTkuNC0yLjUtMjItMTUuMS0zMS4zIC04LjYtNi4zLTI2LjYtMTIuMi00NCAxLjRDMTE1LjYtNS40IDczLjUgMS43IDU4LjUgMTEuNmMtMTIuNSA4LjItMjYuNiAyMy0yNiA0Ny44QzMzLjEgMzYuNCA0Ni41IDIyLjUgNTguNSAxNC42eiIgZmlsbD0iI0UzRjRGRiIvPjxwYXRoIGQ9Ik0zMy45IDc0LjRjLTAuMi0xLTAuNC0xLjktMC41LTIuOEMxNC4yIDc3LjEgMCA5NC42IDAgMTE1LjZjMCAwLjUgMCAwLjkgMCAxLjRDMC44IDk2LjUgMTQuOSA3OS43IDMzLjkgNzQuNHoiIGZpbGw9IiNFM0Y0RkYiLz48cGF0aCBkPSJNODUuOSAxOTcuOWMwIDAgMCAwIDAgMC4xIDAgMCAwIDAgMC0wLjF2MC4xYy0wLjkgMS4xLTMuNiA0LjYtMy43IDcuMyAtMC4xIDIuNyAyLjEgNC4yIDMuNyA0LjN2MGMwIDAgMCAwIDAgMCAwIDAgMCAwIDAgMHYwYzEuNi0wLjEgMy43LTEuNSAzLjctNC4zIC0wLjEtMi43LTIuOC02LjItMy43LTcuM1YxOTcuOXpNMTk3LjggMTk3LjFjMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDB2MGMxLjYtMC4xIDMuNy0xLjUgMy43LTQuMyAwLTIuNy0yLjgtNi4yLTMuNy03LjN2LTAuMWMwIDAgMCAwIDAgMC4xIDAgMCAwIDAgMC0wLjF2MC4xYy0wLjkgMS4xLTMuNiA0LjYtMy43IDcuMyAtMC4xIDIuNyAyLjEgNC4yIDMuNyA0LjNWMTk3LjF6TTY1LjYgMjA2LjdjMCAwIDAgMC4xLTAuMSAwLjEgMCAwIDAtMC4xLTAuMS0wLjF2MC4yYy0xLjMgMS42LTUuMyA2LjYtNS4zIDEwLjUgLTAuMSA0IDMgNi4xIDUuMyA2LjF2MGMwIDAgMCAwIDAuMSAwIDAgMCAwIDAgMC4xIDB2MGMyLjMtMC4xIDUuNC0yLjIgNS4zLTYuMSAtMC4xLTMuOS00LTguOS01LjMtMTAuNVYyMDYuN3pNMTQwLjIgMjQ4LjNjMCAwIDAgMCAwLjEgMCAwIDAgMCAwIDAuMSAwdjBjMi4zLTAuMSA1LjQtMi4yIDUuMy02LjEgLTAuMS0zLjktNC04LjktNS4zLTEwLjV2LTAuMmMwIDAgMCAwLjEtMC4xIDAuMSAwIDAgMC0wLjEtMC4xLTAuMXYwLjJjLTEuMyAxLjYtNS4zIDYuNi01LjMgMTAuNSAtMC4xIDQgMyA2LjEgNS4zIDYuMVYyNDguM3pNMTY5LjggMjEzLjhjMCAwIDAgMC4xLTAuMSAwLjEgMCAwIDAtMC4xLTAuMS0wLjF2MC4yYy0xLjMgMS42LTUuMyA2LjYtNS4zIDEwLjUgLTAuMSA0IDMgNi4xIDUuMyA2LjF2MGMwIDAgMCAwIDAuMSAwIDAgMCAwIDAgMC4xIDB2MGMyLjMtMC4xIDUuNC0yLjIgNS4zLTYuMSAtMC4xLTMuOS00LTguOS01LjMtMTAuNVYyMTMuOHpNMTI2LjMgMTkyLjZjMCAwIDAgMC4xLTAuMSAwLjEgMCAwIDAtMC4xLTAuMS0wLjF2MC4yYy0xLjMgMS42LTUuMyA2LjYtNS4zIDEwLjUgLTAuMSA0IDMgNi4xIDUuMyA2LjF2MGMwIDAgMCAwIDAuMSAwIDAgMCAwIDAgMC4xIDB2MGMyLjMtMC4xIDUuNC0yLjIgNS4zLTYuMSAtMC4xLTMuOS00LTguOS01LjMtMTAuNVYxOTIuNnpNODIuNyAyNDAuNGMwIDAgMCAwLjEtMC4xIDAuMSAwIDAgMC0wLjEtMC4xLTAuMXYwLjJjLTEuMyAxLjYtNS4zIDYuNi01LjMgMTAuNSAtMC4xIDQgMyA2LjEgNS4zIDYuMXYwYzAgMCAwIDAgMC4xIDAgMCAwIDAgMCAwLjEgMHYwYzIuMy0wLjEgNS40LTIuMiA1LjMtNi4xIC0wLjEtMy45LTQtOC45LTUuMy0xMC41VjI0MC40ek0zOS4yIDIwOC41YzAgMCAwIDAuMS0wLjEgMC4xIDAgMCAwLTAuMS0wLjEtMC4xdjAuMmMtMS4zIDEuNi01LjMgNi42LTUuMyAxMC41IC0wLjEgNCAzIDYuMSA1LjMgNi4xdjBjMCAwIDAgMCAwLjEgMCAwIDAgMCAwIDAuMSAwdjBjMi4zLTAuMSA1LjQtMi4yIDUuMy02LjEgLTAuMS0zLjktNC04LjktNS4zLTEwLjVWMjA4LjV6TTExMi4zIDI1OS44YzAgMCAwIDAuMS0wLjEgMC4xIDAgMCAwLTAuMS0wLjEtMC4xdjAuMmMtMS4zIDEuNi01LjMgNi42LTUuMyAxMC41IC0wLjEgNCAzIDYuMSA1LjMgNi4xdjBjMCAwIDAgMCAwLjEgMCAwIDAgMCAwIDAuMSAwdjBjMi4zLTAuMSA1LjQtMi4yIDUuMy02LjEgLTAuMS0zLjktNC04LjktNS4zLTEwLjVWMjU5Ljh6TTE1NC4zIDIwMC43di0wLjFjMCAwIDAgMCAwIDAuMSAwIDAgMCAwIDAtMC4xdjAuMWMtMC45IDEuMi0zLjggNC45LTMuOSA3LjcgLTAuMSAyLjkgMi4yIDQuNSAzLjkgNC41djBjMCAwIDAgMCAwIDBzMCAwIDAgMHYwYzEuNy0wLjEgMy45LTEuNiAzLjgtNC41QzE1OC4xIDIwNS42IDE1NS4yIDIwMS45IDE1NC4zIDIwMC43ek0xMTUuNCAyMzcuOGMwIDAgMCAwIDAgMC4xIDAgMCAwIDAgMC0wLjF2MC4xYy0wLjkgMS4yLTMuOCA0LjktMy45IDcuNyAtMC4xIDIuOSAyLjIgNC41IDMuOSA0LjV2MGMwIDAgMCAwIDAgMCAwIDAgMCAwIDAgMHYwYzEuNy0wLjEgMy45LTEuNiAzLjgtNC41IC0wLjEtMi45LTIuOS02LjUtMy44LTcuN1YyMzcuOHpNMTYyLjEgMjQ4LjRjMCAwIDAgMCAwIDAuMSAwIDAgMCAwIDAtMC4xdjAuMWMtMC45IDEuMi0zLjggNC45LTMuOSA3LjcgLTAuMSAyLjkgMi4yIDQuNSAzLjkgNC41djBjMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDB2MGMxLjctMC4xIDMuOS0xLjYgMy44LTQuNSAtMC4xLTIuOS0yLjktNi41LTMuOC03LjdWMjQ4LjR6TTUzLjIgMTg4LjJjMCAwIDAgMCAwIDAuMSAwIDAgMCAwIDAtMC4xdjAuMWMtMC45IDEuMi0zLjggNC45LTMuOSA3LjcgLTAuMSAyLjkgMi4yIDQuNSAzLjkgNC41djBjMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDB2MGMxLjctMC4xIDMuOS0xLjYgMy44LTQuNSAtMC4xLTIuOS0yLjktNi41LTMuOC03LjdWMTg4LjJ6TTQ4LjUgMjM3LjhjMCAwIDAgMCAwIDAuMSAwIDAgMCAwIDAtMC4xdjAuMWMtMC45IDEuMi0zLjggNC45LTMuOSA3LjcgLTAuMSAyLjkgMi4yIDQuNSAzLjkgNC41djBjMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDB2MGMxLjctMC4xIDMuOS0xLjYgMy44LTQuNSAtMC4xLTIuOS0yLjktNi41LTMuOC03LjdWMjM3Ljh6TTEwMS40IDIxNC43YzAgMCAwIDAgMCAwLjEgMCAwIDAgMCAwLTAuMXYwLjFjLTAuOSAxLjItMy44IDQuOS0zLjkgNy43IC0wLjEgMi45IDIuMiA0LjUgMy45IDQuNXYwYzAgMCAwIDAgMCAwIDAgMCAwIDAgMCAwdjBjMS43LTAuMSAzLjktMS42IDMuOC00LjUgLTAuMS0yLjktMi45LTYuNS0zLjgtNy43VjIxNC43ek0xNzQuNSAxODguMmMwIDAgMCAwIDAgMC4xIDAgMCAwIDAgMC0wLjF2MC4xYy0wLjkgMS4yLTMuOCA0LjktMy45IDcuNyAtMC4xIDIuOSAyLjIgNC41IDMuOSA0LjV2MGMwIDAgMCAwIDAgMCAwIDAgMCAwIDAgMHYwYzEuNy0wLjEgMy45LTEuNiAzLjgtNC41IC0wLjEtMi45LTIuOS02LjUtMy44LTcuN1YxODguMnpNMTg1LjQgMjU1LjVjMCAwIDAgMCAwIDAuMSAwIDAgMCAwIDAtMC4xdjAuMWMtMC45IDEuMi0zLjggNC45LTMuOSA3LjcgLTAuMSAyLjkgMi4yIDQuNSAzLjkgNC41djBjMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDB2MGMxLjctMC4xIDMuOS0xLjYgMy44LTQuNSAtMC4xLTIuOS0yLjktNi41LTMuOC03LjdWMjU1LjV6TTE5OS40IDIyMy43di0wLjFjMCAwIDAgMCAwIDAuMSAwIDAgMCAwIDAtMC4xdjAuMWMtMC45IDEuMi0zLjggNC45LTMuOSA3LjcgLTAuMSAyLjkgMi4yIDQuNSAzLjkgNC41djBjMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDB2MGMxLjctMC4xIDMuOS0xLjYgMy44LTQuNUMyMDMuMiAyMjguNiAyMDAuMyAyMjQuOSAxOTkuNCAyMjMuN3pNMjguMyAyNDYuOGMwIDAgMCAwIDAgMC4xIDAgMCAwIDAgMC0wLjF2MC4xYy0wLjkgMS4yLTMuOCA0LjktMy45IDcuNyAtMC4xIDIuOSAyLjIgNC41IDMuOSA0LjV2MGMwIDAgMCAwIDAgMHMwIDAgMCAwdjBjMS43LTAuMSAzLjktMS42IDMuOC00LjUgLTAuMS0yLjktMi45LTYuNS0zLjgtNy43VjI0Ni44ek02MSAyNjIuN2MwIDAgMCAwIDAgMC4xIDAgMCAwIDAgMC0wLjF2MC4xYy0wLjkgMS4yLTMuOCA0LjktMy45IDcuNyAtMC4xIDIuOSAyLjIgNC41IDMuOSA0LjV2MGMwIDAgMCAwIDAgMCAwIDAgMCAwIDAgMHYwYzEuNy0wLjEgMy45LTEuNiAzLjgtNC41IC0wLjEtMi45LTIuOS02LjUtMy44LTcuN1YyNjIuN3pNMTQyLjMgMjcxLjVjMCAwIDAgMCAwIDAuMSAwIDAgMCAwIDAtMC4xdjAuMWMtMC45IDEuMi0zLjggNC45LTMuOSA3LjcgLTAuMSAyLjkgMi4yIDQuNSAzLjkgNC41djBjMCAwIDAgMCAwIDAgMCAwIDAgMCAwIDB2MGMxLjctMC4xIDMuOS0xLjYgMy44LTQuNSAtMC4xLTIuOS0yLjktNi41LTMuOC03LjdWMjcxLjV6IiBmaWxsPSIjOURFMkZGIi8+PHBhdGggZD0iTTEzNi4xIDEwNC43bC0xNi4xIDM5LjVoMzEuOWwtNjcuNiA0NC4xIDE1LjgtNDQuMUg3NS43bDE2LjEtMzkuNkwxMzYuMSAxMDQuN3oiIGZpbGw9IiNGRkMwMDAiLz48cG9seWdvbiBwb2ludHM9IjEyMCAxNDQuMSAxMTguOCAxNDcuMSAxNDcuNCAxNDcuMSAxNTIgMTQ0LjEgIiBmaWxsPSIjRkZFQjAwIi8+PHBvbHlnb24gcG9pbnRzPSI5MC41IDEwNy41IDEzNC45IDEwNy43IDEzNi4xIDEwNC43IDkxLjggMTA0LjUgIiBmaWxsPSIjRkZFQjAwIi8+PC9zdmc+) 50% 6em no-repeat;
                    background-size: 30% auto
                }

                .main {
                    -webkit-box-flex: 1;
                    -ms-flex: 1 1 70%;
                    flex: 1 1 70%;
                    box-sizing: border-box;
                    padding: 10rem 5rem 5rem;
                    min-height: 100vh
                }

                .error-description {
                    -webkit-box-flex: 1;
                    -ms-flex: 1;
                    flex: 1
                }

                .help-actions {
                    margin-bottom: 30px
                }

                .help-actions a {
                    display: inline-block;
                    border: 2px solid #d32f2f;
                    margin: 0 .5rem .5rem 0;
                    padding: .5rem 1rem;
                    text-decoration: none;
                    -webkit-transition: .25s ease;
                    transition: .25s ease
                }

                .help-actions a:hover {
                    text-decoration: none;
                    background: #d32f2f;
                    color: #fff
                }

                pre.debug {
                    display: none;
                    background-color: #000;
                    color: #fff;
                    font-size: 13.5px;
                    font-family: Consolas, Monaco, Lucida Console, Liberation Mono, DejaVu Sans Mono, Bitstream Vera Sans Mono, Courier New, monospace;
                    width: 100%;
                    border: #484848 3px;
                    border-top-style: none;
                    border-right-style: none;
                    border-bottom-style: none;
                    border-left-style: none;
                    border-style: double;
                    line-height: 1.15;
                    padding-top: 6px;
                    padding-bottom: 6px;
                    padding-left: 10px;
                    padding-right: 10px
                }

                @media (max-width:959px) {
                    .page:before {
                        -ms-flex-preferred-size: 400px;
                        flex-basis: 400px;
                        background-position: 50% 4rem
                    }
                    .main {
                        padding: 5rem
                    }
                }

                @media (max-width:769px) {
                    .page {
                        -webkit-box-orient: vertical;
                        -webkit-box-direction: normal;
                        -ms-flex-direction: column;
                        flex-direction: column
                    }
                    .page:before {
                        -ms-flex-preferred-size: 250px;
                        flex-basis: 250px;
                        background-position: 5rem -4.8rem;
                        background-size: 166px auto
                    }
                    .main {
                        min-height: 0;
                        -webkit-box-flex: 0;
                        -ms-flex: none;
                        flex: none
                    }
                }

                @media (max-width:479px) {
                    h2 {
                        font-size: 3rem
                    }
                    .main {
                        padding: 3rem
                    }
                }
            </style>

        </head>

        <body>
        <script>function debug(){"true"==document.getElementById("debughidden").value?(document.getElementById("dbgbutton").innerText="Hide Debug Information",document.getElementById("debughidden").value="false",document.getElementById("versiondbg").innerText="Debugging Information:",document.getElementsByClassName("debug")[0].style.display="block"):(document.getElementById("dbgbutton").innerText="Show Debug Information",document.getElementById("debughidden").value="true",document.getElementById("versiondbg").innerHTML="<strong>BlackHawk/<?PHP HTMLUtils::print(str_replace("v", "", BLACKHAWK_VERSION));?></strong>&nbsp;(<?=BLACKHAWK_OS?>; <?=BLACKHAWK_BUILD_DATE?>)",document.getElementsByClassName("debug")[0].style.display="none")}</script>
        <div class="page">
            <div class="main">
                <input type="hidden" id="debughidden" value="true">
                <h1>Server Error</h1>
                <div class="error-code">
                    <?PHP HTMLUtils::print($code);?>
                </div>
                <h2><?PHP HTMLUtils::print($error);?></h2>
                <p class="lead"><?PHP HTMLUtils::print($info, ($escapeHtml ? false : true));?></p>
                <hr>
                <p>That's what you can do:</p>
                <div class="help-actions"> <a href="javascript:location.reload();">Reload Page</a> <a href="javascript:debug();" id="dbgbutton">Show Debug Information</a><a href="javascript:history.back();">Back to Previous Page</a></div>
                <p id="versiondbg"><strong>BlackHawk/<?PHP HTMLUtils::print(str_replace("v", "", BLACKHAWK_VERSION));?></strong>&nbsp;(<?=BLACKHAWK_OS?>; <?=BLACKHAWK_BUILD_DATE?>)</p>
                <pre class="debug" style="display: none;">DebugResult Object (
  [message:protected] =&gt; Debugging triggered by BlackHawk\IO\Userland\LoadBalancer\userspace.go:&lt;0xF5CCB410&gt;&lt;_fmt.services.encoreInvoker.httpStatusErr(1126)&gt;
  [BlackHawk:protected][ReleaseInfo] =&gt; struct (
    [vendor] =&gt; "NightHawk Development Group LLC"
    [copyright] =&gt; "(C) 2020 NightHawk Development Group LLC. All rights reserved."
    [version] =&gt; "<?=BLACKHAWK_VERSION?>"
    [build:protected] =&gt; struct (
      [type] =&gt; "production"
      [build_date] =&gt; "<?=BLACKHAWK_BUILD_DATE?>"
      [builder] =&gt; "antiengineer@intellivoid.production-clangbuilds_442.kw7.hpe-tier5"
      [toolchain] =&gt; "gccgo"
      [compiler] =&gt; "clang-gcc cgo (clang-1001.0.46.4)
      [release_keys] =&gt; ["production", "release", "zbv1.1.1"]
    )
  )
  [Userspace._invokeError:public] =&gt; UserSpaceError Object (
    [error] =&gt; "<?=$error?>"
    [httpCode] =&gt; <?=$code?>

    [action] =&gt; Types.ServiceThreading::KillConcurrentReflectiveHTTPThread&lt;0x05970010&gt; Type (
      [result] =&gt; "Success"
      [correlationId] =&gt; "<?=Utilities::createUUID()?>"
      [devFinger] =&gt; "<?=Utilities::createDeviceFingerprint()?>"
      [Thread:private] =&gt; Thread Object (
        [status] =&gt; "halt"
      )
    )
  )
)</pre></div>

        </div>
        </body>

        </html>
        <?php
    }
}