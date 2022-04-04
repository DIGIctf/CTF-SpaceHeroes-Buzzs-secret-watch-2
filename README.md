# SpaceHeroes-Buzzs-secret-watch-2

This was of my favorite CTF challenges. I created a script that told me the RGB hex value from an image giving x,y coordinates.

There is an avi file
```
https://www.dropbox.com/s/d917f0tba7810b6/buzz-bin.avi
```

It's ~5 minutes long showing a fast sequence of 8 circles that are in 3 variations; all red, all black, or green in some/all of them.

Since there were 8 circles, my hunch was binary.

After viewing the video file, every other frame indicated all 8 circles were red. Those were irrelevant to finding the binary. If they were all black, that represented "00000000". If the image had any of the green circles, that represented "1".

Example: 10110001 would be [green][black][green][green][black][black][black][green]

I used ffmpeg to export the frames from the avi video. 

```
ffmpeg -r 1 -i ../buzz-bin.avi -vf scale=-1:240 -r:v "1/2" "$filename%05d.png"
```
Note: The reason I did $filename%05d.png was because each file was 5 digits long and I needed leading zeros. i.e. $filename00001.png vs $filename1.png

This took about 10 minutes exporting all 32,470. I decided to do every other frame (because I don't need the images that show all red circles) - that is why I did "1/2" with ffmpeg above.

After 10 minutes of exporting, I got 16,235 images. 

Now the fun part to write a script. My background is with PHP so that's why it's written in PHP instead of python. I needed a way to check an exact pixel with x/y coordinates and determine the color. imagecolorsforindex is the PHP function that does exactly this.

```
$colors = imagecolorsforindex($image, $rgb); // Assign color name and its value.

$color = sprintf("#%02x%02x%02x", $colors['red'], $colors['green'], $colors['blue']); // #0d00ff
```

I needed to loop through this 8 times for each circle. 

My biggest dilemma was the resolution. Keep in mind, I shrunk the resolution down to 240 so the file size would be smaller. The problem with this approach was the colors tend to bleed into a specific x/y axis. At first run, it gave inconsistent results. To fix this, I decided to check 9 pixels of each circle, a 3x3 grid. The script would check for code #000000 for black and #00FF00 for green.

![alt text](https://raw.githubusercontent.com/digijeff81/SpaceHeroes-Buzzs-secret-watch-2/main/grid.jpg)

Once I got the binary code of all 16,235 images that outputed into output.txt I used https://gchq.github.io/CyberChef/ to get the flag which was in an ELF file.

![alt text](https://raw.githubusercontent.com/digijeff81/SpaceHeroes-Buzzs-secret-watch-2/main/flag.jpg)



