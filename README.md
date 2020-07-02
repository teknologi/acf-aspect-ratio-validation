# ACF aspect ratio validation for image fields

Adds a field setting to ACF Image fields and validates images to ensure that they meet image aspect ratio requirement

This also serves as an example of how to add multiple settings to a single row when adding settings to an ACF field type.

side note: after implementing this code clear your browser cache to ensure the needed JS and WP media window is refreshed.

## What is "Margin"?

When setting up this validation, besides the aspect ratio, you also have the option to specify a margin. How does this affect validation?

Let's say that you set an aspect ratio of 1:1 with a margin of 10%.

If the width of the image is 100 pixels, this means that the height of the image can be from 90 pixels to 110 pixels 100 +/- 10% (10px).

If the aspect ration is set to 4:3 and the margin at 1% if the width of the uploaded image is 800 pixels then the height can be 594 to 606 pixels
 600 +/- 1% (6px).

## Credit

All credit for this code goes to John A. Huebner II. He has a boatload of other nice ACF addition over at his [Github account](https://github.com/Hube2). I highly recommend them.