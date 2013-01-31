class window.Spirit extends Drawable
  constructor: (config) ->
    super 0,0,config.width, config.height
    @imgSource = config.img
    @movingPx = config.movingPixel
    @actiontypes = config.actiontypes
    @actionstates = config.actionstates
    @currentAction = @actiontypes.staying
    @currentState = @actionstates.staying0
    return
  contains : (pos) ->
    return @x < pos.x < @x+@width and @y < pos.y < @y+@width
  onDraw : ->
      @consumeState()
      @x += @currentState.offsetX * @movingPx
      @y += @currentState.offsetY * @movingPx
      @context.drawImage @imgSource, @currentState.image_col_index * @width, @currentState.image_row_index * @height, @width, @height, @x, @y, @width, @height

  consumeState:->
    @currentState = ActionStates[@currentState[@currentAction]] if @currentAction isnt null and @currentAction isnt undefined
    return
