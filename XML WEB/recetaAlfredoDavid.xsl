<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet xmlns:xsl="http://www.w3.org/1999/XSL/Transform" version="1.0">
    <xsl:output method="html" encoding="UTF-8" indent="yes"/>
    
    <!-- Plantilla principal -->
    <xsl:template match="/">
        <html>
            <head>
                <title>Recetas de Cocina</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 20px;
                    }
                    h1 {
                        color: #5D5C61;
                    }
                    h2 {
                        color: #379683;
                    }
                    .receta {
                        border: 1px solid #ddd;
                        padding: 15px;
                        margin-bottom: 20px;
                        border-radius: 5px;
                        background-color: #f9f9f9;
                    }
                    .ingredientes, .pasos {
                        margin-top: 10px;
                        padding-left: 20px;
                    }
                </style>
            </head>
            <body>
                <h1>Recetas de Cocina</h1>
                <!-- Recetas -->
                <xsl:for-each select="recetas/receta">
                    <div class="receta">
                        <h2><xsl:value-of select="@nombre"/></h2>
                        <p><strong>Tipo:</strong> <xsl:value-of select="@tipo"/></p>
                        <p><strong>Calorías:</strong> <xsl:value-of select="@calorias"/></p>
                        <p><strong>Dificultad:</strong> <xsl:value-of select="@dificultad"/></p>
                        <p><strong>Tiempo:</strong> <xsl:value-of select="@tiempo"/></p>
                        <p><strong>Elementos:</strong> <xsl:value-of select="@elementos"/></p>
                        <p><strong>Emplatado:</strong> <xsl:value-of select="@emplatado"/></p>
                        <p><strong>Fuente:</strong> 
                            <a href="{@origen}" target="_blank"><xsl:value-of select="@origen"/></a>
                        </p>
                        
                        <h3>Ingredientes:</h3>
                        <ul class="ingredientes">
                            <!-- ingredientes de la receta-->
                            <xsl:for-each select="ingrediente">
                                <li>
                                    <xsl:value-of select="@nombre"/> - 
                                    <xsl:value-of select="@cantidad"/>
                                </li>
                            </xsl:for-each>
                        </ul>
                        
                        <h3>Pasos de preparación:</h3>
                        <ol class="pasos">
                            <!-- Pasos de la receta -->
                            <xsl:for-each select  ="paso">
                                <li><xsl:value-of select="."/></li>
                            </xsl:for-each>
                        </ol>
                    </div>
                </xsl:for-each>
            </body>
        </html>
    </xsl:template>
</xsl:stylesheet>
