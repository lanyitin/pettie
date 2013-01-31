class window.AttributeBar extends View
  constructor : (config) ->

    @value = config.value
    @maxValue = config.maxValue

    @caption = config.caption
    @captionText = new TextDrawable(@caption, config.x, config.y)
    @prograssbar = new PrograssBar
      x: config.x
      y: config.y
      width: 100
      height:16
      value: @value
      maxValue:@maxValue
    @valueText = new TextDrawable("#{@value}/#{@maxValue}", config.x, config.y)
    super(config)
    @add @captionText
    @add @prograssbar
    @add @valueText
    return
  onDraw : ->
    padding = 5
    @prograssbar.setOffsetX @captionText.getWidth() + padding
    @valueText.setOffsetX @captionText.getWidth() + @prograssbar.getWidth() + padding
    @captionText.draw()
    if (@value/@maxValue) >= 0.75
      @setFillStyle "green"
    else if 0.25 <= (@value/@maxValue) < 0.75
      @setFillStyle "orange"
    else if 0.25 > (@value/@maxValue)
      @setFillStyle "red"
    @prograssbar.draw()
    @valueText.draw()
    return
  setText : (@text) ->
    @captionText.setText(@text)
    return
  setValue : (@value) ->
    @value = parseInt @value
    @prograssbar.setValue @value
    @valueText.setText "#{@value}/#{@maxValue}"
    return
  setFillStyle : (fillStyle) ->
    @prograssbar.setFillStyle fillStyle
    return
  setStrokeStyle : (strokeStyle) ->
    @prograssbar.setStrokeStyle strokeStyle
    return
  setFont : (@font) ->
    @captionText.setFont @font
    @valueText.setFont @font
  contains : (pLocation) ->
    if (pLocation.x > @captionText.x && pLocation.x < @valueText.x + @valueText.width) && (pLocation.y > @y && pLocation < @prograssbar.y + @prograssbar.height)
      return true
    else
      return false
