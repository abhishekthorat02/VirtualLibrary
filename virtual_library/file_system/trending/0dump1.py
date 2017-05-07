#!/usr/bin/env python
#this code is belongs to student abhishek anil thorat (college of engineering pune)
#email : abhishekthorat02@gmail.com
#Copy and Distribute the software however you want.
#If you want to add or remove functionality, go ahead. If you want to use a portion of the code in another project, you can. The only catch is that the other project must also be released under the GPL(as a open source code).
#this code is totally based on python



import pygtk
import gtk
#############

import webkit
def go_button(widget):
	add = addressbar.get_text()
	infile = open("/home/abhishek/dump/database", "a")
	add = "https://" + add
	addressbar.set_text(add)
	f = str(add+'\n')
	infile.write(f)
	infile.close()
        addressbar.set_text(add)
	#webbrowser.open(add)
        web.open(add)

###############

def prev_button(widget):
	

	
	non_blank_count = 0

	with open('/home/abhishek/dump/database') as infp:
		for line in infp:
			if line.strip():
				non_blank_count += 1

	print 'number of non-blank lines found %d' % non_blank_count



	file = open("/home/abhishek/dump/database", "r")
	
	file_lines = file.readlines()
	text = file_lines[non_blank_count - 2].strip()
	addressbar.set_text(text)
	web.open(text)
################

def next_button(widget):
	
	non_blank_count = 0

	with open('/home/abhishek/dump/database') as infp:
		for line in infp:
			if line.strip():
				non_blank_count += 1

	print 'number of non-blank lines found %d' % non_blank_count
	
	file = open("/home/abhishek/dump/database", "r")
	
	file_lines = file.readlines()
	text = file_lines[non_blank_count - 1].strip()
	addressbar.set_text(text)
	web.open(text)
###############
def goal_button(widget):
	add = "https://www.youtube.com"
	web.open(add)

def google_button(widget):
	add = "https://www.google.com"
	web.open(add)
def wiki_button(widget):
	add = "https://www.wikipedia.com"
	web.open(add)
################

#def newtab_fun(widget):
	
	#win1 = gtk.Window(gtk.WINDOW_TOPLEVEL)
	#win1.set_size_request(600,500)
	#win1.connect('destroy', lambda w:gtk.main_quit())
	#box1 = gtk.VBox()
	#win1.add(box1)
	#box2 = gtk.HBox()
	#box1.pack_start(box2, False)
	#next = gtk.Button("-->")
	#prev = gtk.Button(" <--")
	#gobutton = gtk.Button("GO")
	#newtab = gtk.Button("new tab")
	#addressbar = gtk.Entry()
	#box2.pack_start(gobutton)
	#box2.pack_start(addressbar)
	#box2.pack_start(next)
	#box2.pack_start(prev)
	#box2.pack_start(newtab)
	#gobutton.connect('clicked',go_button)
	#prev.connect('clicked',prev_button)
	#newtab.connect('clicked',newtab_fun)


	#scroller = gtk.ScrolledWindow()
	#box1.pack_start(scroller)
	#win1.show_all()
	
	



################
win = gtk.Window()
win.set_size_request(600,500)
win.connect('destroy', lambda w:gtk.main_quit())     
win.set_title("WORLD WIDE ")

###############

box1 = gtk.VBox()
win.add(box1)
box2 = gtk.HBox()
box3 = gtk.HBox()
box1.pack_start(box2, False)
box1.pack_start(box3, False)
next = gtk.Button()
prev = gtk.Button()
gobutton = gtk.Button()

#newtab = gtk.Button("new tab")
bookmark1 =gtk.Button()
bookmark2 =gtk.Button()
bookmark3 =gtk.Button("wikipedia")
addressbar = gtk.Entry()
image = gtk.Image()
image1 = gtk.Image()
image2 = gtk.Image()
image3 = gtk.Image()
image4 = gtk.Image()
image5 = gtk.Image()
image.set_from_file("/home/abhishek/dump/gtk_search.png")
image1.set_from_file("/home/abhishek/dump/arrow_right.png")
image2.set_from_file("/home/abhishek/dump/arrow_large_left.png")
image3.set_from_file("/home/abhishek/dump/mini_google.png")
image4.set_from_file("/home/abhishek/dump/youtube_cloud.png")
image5.set_from_file("/home/abhishek/dump/wikipedia.png")
gobutton.set_image(image)
next.set_image(image1)
prev.set_image(image2)
bookmark1.set_image(image3)
bookmark2.set_image(image4)
bookmark3.set_image(image5)
box2.pack_start(gobutton,False,0)
box2.pack_start(addressbar)
box2.pack_start(next,False,0)
box2.pack_start(prev,False,0)
#box2.pack_start(image)
#box2.pack_start(newtab)
box3.pack_start(bookmark1,False,0) 
box3.pack_start(bookmark2,False,0) 
box3.pack_start(bookmark3,False,0) 

###############
gobutton.set_tooltip_text("go to the given address")
next.set_tooltip_text("next web address")
prev.set_tooltip_text("previous web address")





###############
gobutton.connect('clicked',go_button)
#gobutton.connect('enter',go_button)
prev.connect('clicked',prev_button)
next.connect('clicked',next_button)
bookmark1.connect('clicked',google_button)
bookmark2.connect('clicked',goal_button)
bookmark3.connect('clicked',wiki_button)
#newtab.connect('clicked',newtab_fun)


scroller = gtk.ScrolledWindow()
box1.pack_start(scroller)

web = webkit.WebView()
scroller.add(web)

win.show_all()

gtk.main()

