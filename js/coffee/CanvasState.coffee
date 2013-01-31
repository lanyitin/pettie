class window.CanvasState
	_MouseState = {"up":"up", "down": "down"}
	constructor : (@canvas) ->
		self = @
		@context = @canvas.getContext "2d"
		@drawables = []
		@canOpWork = true
		@canvas.addEventListener "click", (evt)->
			evt.cancelBubble = true
			evt.stopPropagation()
			mousePos = self.getMouse evt
			
			if self.canOpWork
				self.drawables.forEach (pElement) ->
					if typeof pElement.click is "function" and pElement.contains mousePos
						pElement.click evt, mousePos
			return

		@canvas.addEventListener "mousedown", (evt)->
			evt.cancelBubble = true
			evt.stopPropagation()
			mousePos = self.getMouse evt
			drawable.mousedown evt, mousePos for drawable in self.drawables when typeof drawable.mousedown is "function" and drawable.contains mousePos
			return

		@canvas.addEventListener "mouseup", (evt)->
			evt.cancelBubble = true
			evt.stopPropagation()
			mousePos = self.getMouse evt
			drawable.mouseup evt, mousePos for drawable in self.drawables when typeof drawable.mouseup is "function" and drawable.contains mousePos
			return

		@canvas.addEventListener "mousemove", (evt)->
			evt.cancelBubble = true
			evt.stopPropagation()
			mousePos = self.getMouse evt
			drawable.mousemove evt, mousePos for drawable in self.drawables when typeof drawable.mousemove is "function" and drawable.contains mousePos
			return

	addDrawable : (pDrawable) ->
		pDrawable.setContext @context
		@drawables.push pDrawable
		return

	getMouse : (e) ->
		element = @canvas
		offsetX = offsetY = 0
		if element.offsetParent isnt undefined
			offsetX += element.offsetLeft
			offsetY += element.offsetTop
			while element = element.offsetParent
				offsetX += element.offsetLeft
				offsetY += element.offsetTop
		obj =
			x:e.pageX - offsetX
			y:e.pageY - offsetY
		return obj
