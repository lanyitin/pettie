class window.ImageDrawable extends RectDrawable
  constructor: (@image, x, y, width, height) ->
    super x, y, width, height
  onDraw: ->
    if @getWidth() && @getHeight()
      @context.drawImage @image, @x + @getOffsetX(), @y + @getOffsetY(), @width, @height
    else
      @context.drawImage @image, @x, @y
      @setWidth @image.width
      @setHeight @image.height
  setImg: (@image) ->
    console.assert @image.src isnt undefined
    return
