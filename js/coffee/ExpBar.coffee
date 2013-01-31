class window.ExpBar extends Drawable
  constructor : (config) ->
    super(config.x, config.y , config.width, config.height)
    @baseImg = config.baseImg
    @maskImg = config.maskImg
    @percentage = 0
    @baseCanvas = document.createElement "canvas"
    @baseContext = @baseCanvas.getContext "2d"
    @bufferCanvas = document.createElement "canvas"
    @bufferContext = @bufferCanvas.getContext "2d"
    @baseCanvas.width = @width
    @baseCanvas.height = @height
    @bufferCanvas.width = @width
    @bufferCanvas.height = @height * 2
    @bufferContext.drawImage @maskImg, 0, 0, @width, @height
    @baseContext.drawImage @baseImg, 0, 0, @width, @height
    return
  setPercentage : (@percentage) ->
    return
  onDraw : ->
    self = @
    @bufferContext.clearRect 0, @height, @width, @height
    ((offsetY, height) ->
        self.bufferContext.fillRect 0, self.height + offsetY, self.width, height
    )(15 + (@height-10-15) * (1-@percentage), (@height-10-15) * @percentage + 10)
    bufferData = @bufferContext.getImageData 0, @height, @width, @height

    bufferData.data[i+3] = 0 for i in [0..bufferData.data.length - 3] by 4 when bufferData.data[0] is 255 and bufferData.data[1] is 255 and bufferData.data[2] is 255

    maskData = @bufferContext.getImageData 0, 0, @width, @height
    baseData = @baseContext.getImageData 0, 0, @width, @height

    bufferData.data[i] = @getTransparentForBorder (@getTransparentForMask bufferData.data[i], maskData.data[i]), baseData.data[i] for i in [3..bufferData.data.length] by 4

    @bufferContext.putImageData bufferData, 0, @height
    @context.drawImage @bufferCanvas, 0, @height, @width, @height, @x, @y, @width, @height
    return
  getTransparentForMask : (buffer, mask) ->
    if buffer > 200 and mask >200
      return 255
    else
      return 0
  getTransparentForBorder : (buffer, border) ->
    if buffer > 200 or border > 200
      return 255
    else
      return 0
  contains : RectDrawable.prototype.contains
