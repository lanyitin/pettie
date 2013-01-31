targetDeps=  libui.js
coffeeBeans = ./coffee/CanvasState.coffee ./coffee/Drawable.coffee ./coffee/RectDrawable.coffee ./coffee/TextDrawable.coffee ./coffee/ImageDrawable.coffee ./coffee/ArcDrawable.coffee ./coffee/View.coffee ./coffee/PrograssBar.coffee ./coffee/AttributeBar.coffee ./coffee/PrograssBar.coffee ./coffee/Spirit.coffee ./coffee/ExpBar.coffee ./coffee/LinearLayout.coffee
dep := $(foreach a, $(targetDeps), --js $(a))

all: all.js

all.js: $(targetDeps)
		closure --js_output_file $@ $(dep)


libui.js: $(coffeeBeans) 
		coffee -cj $@ $^ 

clean:
		rm all.js
		rm libui.js
