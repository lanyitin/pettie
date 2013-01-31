class window.TextDrawable extends Drawable
  constructor : (text, x, y, width, height) ->
    super x, y, width, height
    @setText text
    return
  setText : (@text) ->
  getText : -> @text
  onDraw: ->
    @setHeight parseInt(@font, 10)
    if @getFill()
      @context.fillText @getText(), @getX() + @getOffsetX(), @getY() + @getOffsetY()
    else
      @context.strokeText @getText(), @getX() + @getOffsetX(), @getY() + @getOffsetY()
    return
  contains: (pLocation) ->
    beginX = @getX()
    endX = @getX() + @getWidth()
    beginY = @getY()
    endY = @getY() + @getHeight()

    if (pLocation.x <= endX  && pLocation.x >= beginX) && (pLocation.y >= beginY && pLocation.y <= endY)
      return true
    else
      return false
  getWidth : ->
    @configContext()
    tMatrix = @context.measureText @text
    tWidth = tMatrix.width
    @setWidth tWidth
    @restoreContext()
    return @width
