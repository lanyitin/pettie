class window.View extends Drawable
  # x, y, widht, height
  constructor: (config) ->
    super(config.x, config.y , config.width, config.height)
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
