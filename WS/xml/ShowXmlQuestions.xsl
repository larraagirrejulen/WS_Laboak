<?xml version="1.0" encoding="ISO-8859-1"?>
<xsl:stylesheet version="1.0"
xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
    <xsl:template match="/">
        <HTML>
            <head>
                <link rel="stylesheet" type="text/css" href="../styles/Tables.css"/>
            </head>
            <body>
                <div class="tableContainer">
                    <table>
                        <thead>
                            <tr style="background-color:#84b29d; font-weight:bold">
                                <td>Egilea</td>
                                <td>Gaia</td>
                                <td>Enutziatua</td>
                                <td>Erantzunak</td>
                                <td>Faltsuak</td>
                            </tr>
                        </thead>
                        <tbody>
                            <xsl:for-each select="/assessmentItems/assessmentItem">
                            <tr style="background-color:#bdffe1">
                                <td><xsl:value-of select="@author"/></td>
                                <td><xsl:value-of select="@subject"/></td>
                                <td><xsl:value-of select="itemBody/p"/></td>
                                <td><xsl:value-of select="correctResponse/response"/></td>
                                <td>
                                    <xsl:for-each select="incorrectResponse/response">
                                        <xsl:value-of select="current()"/><br/>
                                    </xsl:for-each>
                                </td>
                            </tr>
                            </xsl:for-each>
                        </tbody>
                    </table>
                </div>
            </body>
        </HTML>
    </xsl:template>
</xsl:stylesheet>