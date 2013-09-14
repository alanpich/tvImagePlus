---
layout: master
title: Configuration
---

## Configuring an Image+ TV
----------------------------

Image+ gives developers more control over the final size
and ratio of images users can select. When setting up an Image+
TV, there are several configuration options available.


### Size Constraints
Images can be constrained by either width, height, or both
width & height at the same time. Enter a pixel value in either the width or height
field and the crop area will be forced to be at least that width.

If both height & width are specified, the crop area is forced
to the ratio of those values, meaning the user cannot select an
incorrectly sized image, meaning no more broken layouts!

### Other options
Check the 'Show Alt-Text field' box to also allow users to enter
a title/alt-tag string when selecting their image.

In order to display the alt-tag on a page, you will need to use
an output chunk for rendering.
See [Output options](output-options.html) for more details.
