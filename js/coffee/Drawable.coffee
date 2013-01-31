class window.Drawable
  constructor: (@x, @y, @width = 0, @height = 0) ->
    @setFillStyle()
    @setStrokeStyle()
    @setFont()
    @setTextBaseline()
    @setLineWidth()
    @setFill()
    @setOffsetX()
    @setOffsetY()
    @setRotation()

  setX      : (@x = 0) ->
  getX      : -> @x

  setY      : (@y = 0) ->
  getY      : -> @y

  setOffsetX    : (@offsetX = 0) ->
  getOffsetX    : -> @offsetX

  setOffsetY    : (@offsetY = 0) ->
  getOffsetY    : -> @offsetY

  setWidth    : (@width = 0) ->
  getWidth    : -> @width

  setHeight     : (@height = 0) ->
  getHeight     : -> @height
    
  setFillStyle  : (@fillStyle = "black") ->
  getFillStyle  : -> @fillStyle

  setStrokeStyle  : (@strokeStyle = "black") ->
  getStrokeStyle  : -> @strokeStyle

  setFont     : (@font = "16px sans-serif") ->
  getFont     : -> @font
     
  setTextBaseline : (@textBaseline = "top") ->
  getTextBaseline : -> @textBaseline

  setContext    : (@context) ->
  getContext    : -> @context

  setLineWidth  : (@lineWidth = 1) ->
  getLineWidth  : -> @lineWidth

  setFill      : (@fill = 1) ->
  getFill      : -> @fill

  setRotation : (@rotation = 0) ->
  getRotation : -> @rotation

  configContext: ->
    @context.save()
    @context.fillStyle = @fillStyle
    @context.strokeStyle = @strokeStyle
    @context.font = @font
    @context.textBaseline = @textBaseline
    @context.lineWidth = @lineWidth
    @context.rotate @rotation
    return
  restoreContext: ->
    @context.restore()
    return
  draw: ->
    @configContext()
    @onDraw()
    @restoreContext()
    return
  onDraw: ->
    throw new Error "please implement onDraw method for", this
    return
  contains: ->
    throw new Error "please implement contains method for", this
    return
