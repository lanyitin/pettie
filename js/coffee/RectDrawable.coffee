class window.RectDrawable extends Drawable
  constructor: (x, y, width, height) ->
    super x, y, width, height
    return
  onDraw : ->
    if @getFill()
      @context.fillRect @x + @getOffsetX(), @y + @getOffsetY(), @width, @height
    else
      @context.strokeRect @x + @getOffsetX(), @y + @getOffsetY(), @width, @height
    return
  contains : (pLocation) ->
    beginX = @getX()
    endX = @getX() + @getWidth()
    beginY = @getY()
    endY = @getY() + @getHeight()
    if (pLocation.x <= endX  && pLocation.x >= beginX) && (pLocation.y <= endY && pLocation.y >= beginY)
      return true
    else
      return false

