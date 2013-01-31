class window.LinearLayout extends Drawable
  # x, y, widht, height
  constructor: (config) ->
    super(config.x, config.y, config.width, config.height)
    @subView = []
  add: (pDrawable) ->
    pDrawable.setContext @context
    @subView.push pDrawable
    return
  setContext : (context) ->
    super(context)
    @subView.forEach (pElement) ->
      pElement.setContext context
      return
    return
  onDraw : () ->
    for drawable in @subView
      if _i == 0
         drawable.setX @x
         drawable.setY @y
      else
         drawable.setX @subView[_i - 1].x + @subView[_i - 1].width
         drawable.setY @y
      drawable.draw()
    return
  contains : (pLocation) ->
    result = false
    for view in @subView
      if view.contains(pLocation)
        result = true
    return result
