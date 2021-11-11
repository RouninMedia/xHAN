# xHAN
xHAN is *e**x**tended **H**TML **A**ttribute **N**otation*.

HTML attributes typically display as a name-value pair:

**e.g.** `title="This will display as a tooltip"`

Occasionally, we see HTML attributes which have no value:

**e.g.** `checked`

Conventionally, **HTML Attribute Values** consist of a single string - although this string may also include spaces.

If an **HTML Attribute Value** is required to represent a more sophisticated data structure, there aren't many options.

One option - possibly the only one - is for the value to be written as a **JSON String** which may then be parsed into a javascript object (or PHP array etc.):

    myattribute='[{"my": "sophisticated", "data": ["structure", "is", "contained"]}, ["within", "this"], "JSON"]'
    
There really haven't been any other options in HTML. But, then again, in HTML it's probable that no other options are really needed.

In an *HTMLElement-like* structure like a **DaNIS³H Capsule**,  though, an alternative declarative syntax to JSON might well prove very useful.

This is where **xHAN** comes in.

**xHAN** allows for the deployment of indexed, associative and mixed arrays. **xHAN** also allows for multidimensional arrays of these types.

**xHAN** achieves all of this through the simple expedient of allowing an `=` sign to be followed by square brackets (`[...]`), within which comma-separated attribute names, quoted keys and square brackets may be nested - and nested to any depth.

For example the JSON above, written in **xHAN** would look like this:

    myattribute=[[my="sophisticated", data=[structure, is, contained]], [within, this], xHAN]
    
A cursory glance reveals that **xHAN** notation is not radically different from **JSON** notation. But it *is*, quite intentionally, a little shorter and simpler, not least because it is derived from HTML, rather than JavaScript.

