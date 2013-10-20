---
layout: master
title: Configuration
---

## Configuring an Image+ TV
----------------------------

*Image+* gives developers more control over the final size and
ratio of images users can select. When setting up an Image+ TV,
there are several configuration options available.


### Size Constraints
-----------------------
Images can be constrained by either width, height, or both
width & height at the same time. Enter a pixel value in either
the width or height field and the crop area will be forced to be
at least that width.

If both height & width are specified, the crop area is forced to
the ratio of those values, meaning the user cannot select an
incorrectly sized image, meaning no more broken layouts!

### Alt text field
---------------------
Images can also be given an 'alt text' field, which is an additional
piece of text stored with each image that can be output alongside as
an alt-tag or title text

In order to view the alt text on a page, you will need to use either
the Chunk or Snippet output options.


### Allow Empty
-----------------
If 'Allow Empty' is set to 'No', then a user will not be able to save
a resource until they have selected an image and cropped it.


See [output options](output-options.html) for more details.
