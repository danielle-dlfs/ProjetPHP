<?php
/**
 * Created by PhpStorm.
 * User: Danielle
 */

require_once "mesFonctions.inc.php";
?>
<!DOCTYPE html>
<table>
            <thead>
                <tr>
                    <th>Paramètre</th>
                    <th>Retour</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>new</td>
                    <td><? print_r(scriptInfos("new"), true) ?></td>
                </tr>
                <tr>
                    <td>Empty</td>
                    <td><? print_r(scriptInfos("empty"), true) ?></td>
                </tr>
                <tr>
                    <td>proTocol</td>
                    <td><? print_r(scriptInfos("proTocol"), true) ?></td>
                </tr>
                <tr>
                    <td>poRt</td>
                    <td><? print_r(scriptInfos("poRt"), true) ?></td>
                </tr>
                <tr>
                    <td>isPortDef</td>
                    <td><? print_r(scriptInfos("isPortDef"), true) ?></td>
                </tr>
                <tr>
                    <td>dNs</td>
                    <td><? print_r(scriptInfos("dNs"), true) ?></td>
                </tr>
                <tr>
                    <td>path</td>
                    <td><? print_r(scriptInfos("path"), true) ?></td>
                </tr>
                <tr>
                    <td>naME</td>
                    <td><? print_r(scriptInfos("naME"), true) ?></td>
                </tr>
                <tr>
                    <td>short</td>
                    <td><? print_r(scriptInfos("short"), true) ?></td>
                </tr>
                <tr>
                    <td>EXT</td>
                    <td><? print_r(scriptInfos("EXT"), true) ?></td>
                </tr>
                <tr>
                    <td>all</td>
                    <td><?= '<pre>' . print_r(scriptInfos("all"), true) . '</pre>' ?></td>
                </tr>
                <tr>
                    <td>full</td>
                    <td><?= '<pre>' . print_r(scriptInfos("full"), true) . '</pre>' ?></td>
                </tr>
                <tr>
                    <td>root</td>
                    <td><?= '<pre>' . print_r(scriptInfos("root"), true) . '</pre>' ?></td>
                </tr>
                <tr>
                    <td>Machin truc</td>
                    <td><?= '<pre>' . print_r(scriptInfos("Machin truc"), true) . '</pre>' ?></td>
                </tr>
            </tbody>
        </table>
</html>