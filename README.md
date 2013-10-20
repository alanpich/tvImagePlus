# Image+ v3.0 #
## Advanced Image Template Variable

## v3.0 is not backwards compatible with v2.x (yet)

Advanced image TV input type for MODx Revolution.
The required dimensions for the image can (optionally)
be configured on the TV, restricting one or both
dimensions. When the editor uploads an image to the TV,
they can then use a graphical tool to crop the image
to the required dimensions/proportions.

After watching a couple of servers fall over under the weight
of regenerating phpThumbOf cache's on front-end page load,
the decision has been made to refactor Image+ 2.1 in a massive,
life-changing way and do all the image generation in the MODX manager
interface. This has the added benefit of removing any dependencies on
3rd party Extras, and vastly increasing page load speed in the front.
