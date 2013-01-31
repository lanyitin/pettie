class window.ArcDrawable extends Drawable
  constructor: (@radius, @startAngel = 0, @endAngel = 360, x, y) ->
    super x, y

  setRadius : (@radius) ->
  getRadius : -> @radius

  setStartAngel : (@startAngel) ->
  getStartAngel : -> @startAngel

  setEndAngel : (@endAngel) ->
  getEndAngel : -> @endAngel

  onDraw : ->
    @context.beginPath()
    @context.arc(@getX() + @getOffsetX(), @getY() + @getOffsetY(), @getRadius(), @getStartAngel(), @getEndAngel(), true)
    if @getFill()
      @context.fill()
    else
      @context.stroke()
    return

  contains : (pLocation) ->
    if(pMousePos.x < @getX() + @getRadius()) && (pMousePos.x > @getX() - @getRadius()) && ((pMousePos.x < @getX() + @getRadius()) && (pMousePos.x > @getX() - @getRadius()))
      return true
    else
      return false
