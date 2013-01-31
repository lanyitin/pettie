class window.PrograssBar extends View
  # value, maxValue, x, y, width, height
  constructor : (config) ->
    @value = config.value
    @maxValue = config.maxValue
    @fillBlock = new RectDrawable config.x, config.y, (@getDrawingRectWidth(config.value, config.maxValue) / config.maxValue) * config.width, config.height
    @fillBlock.setFill 1
    @fillBlock.setLineWidth 0
    @strokeBlock = new RectDrawable config.x, config.y, config.width, config.height
    @strokeBlock.setFill 0

    super config
    @add @fillBlock
    @add @strokeBlock
    return

  setValue : (@value) ->
    @value = 0 if @value < 0
    @fillBlock.setWidth (@getDrawingRectWidth(@value ,@maxValue) / @maxValue) * @width
    return
  onDraw : ->
    @fillBlock.draw()
    @strokeBlock.draw()
    return
  contains : RectDrawable.prototype.contains
  setOffsetX: (@offsetX) ->
    @fillBlock.setOffsetX @offsetX
    @strokeBlock.setOffsetX @offsetX
    return
  setOffsetY: (@offsetY) ->
    @fillBlock.setOffsetY @offsetY
    @strokeBlock.setOffsetY @offsetY
    return
  setFillStyle: (@fillStyle) ->
    @fillBlock.setFillStyle @fillStyle
    return
  setStrokeStyle: (@strokeStyle) ->
    @strokeBlock.setStrokeStyle @strokeStyle
    return
  getDrawingRectWidth : (currentValue, maxValue) ->
      currentValue -= maxValue while currentValue > maxValue
      return currentValue
