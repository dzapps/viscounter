# Viscounter
PHP based minimalistic hit counter for websites.

##How to use: 3 simple steps
###Step 1: Copy files
Copy the "viscounter" directory (containing "viscounter.php" etc) into the root folder of your website.

###Step 2: Installation
For invisible tracking add the following code to the template file of your CMS or any other page that should be taken into account.
```
<img src="/viscounter/viscounter.php" alt=" "/>
```

As an alternative you may also embed the counting script directly. Then the total number of visitors of the calling page will be returned and displayed as an unformatted number.
```
<?php
include("/viscounter/viscounter.php");
?>
```
###Step 3: View results
Navigate to `http://yourwebsite.com/viscounter`, choose a time frame and get to the results page.
There you will find:
* total number of visitors
* number of visitors within selected time frame
* daily visitors within selected time frame
* detailed hit statistics for every single page
* recent pageloads with client info


## Things to implement
Viscounter is currently limited to basic functionality and still at a very early stage of development. On the one hand this gives you the ability to adapt the source code to your own needs without reading an endless amount of code lines, on the other hand you may have to be patient waiting for the following features to be implemented:
* blocking cookie probiting your own visits being counted
* more detailed stats and their visually appealing presentation
* a more advanced version of the visible counter
* csv export for further analysis with external software



