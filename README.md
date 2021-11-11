# xHAN
xHAN is *e**x**tended **H**TML **A**ttribute **N**otation*.

HTML attributes typically display as a name-value pair:

**e.g.** `title="This will display as a tooltip"`

Occasionally, we see HTML attributes which have a name but no value (since the value is implicit):

**e.g.** `checked`

Where HTML Attributes do have values, then, conventionally, **HTML Attribute Values** consist of a single string.

This string may also include commas or spaces, so rather than a single value, the single string *may* represent a comma-separated (or space-separated) list of values.

But if an **HTML Attribute Value** is required to represent a data structure more sophisticated than a *space-separated list of values*, there aren't many options.

## Using JSON in HTML Attributes
One approach which enables **HTML Attributes** to contain more complex data structures - possibly the only one - is for the HTML Value to be written as a **JSON String** which may then be parsed into a javascript object (or PHP array etc.):

    myattribute='[{"my": "sophisticated", "data": ["structure", "is", "contained"]}, ["within", "this"], "JSON"]'
    
In HTML it's probable that no other approaches are really needed.

## Presenting xHan: an alternative to using JSON in HTML Attributes

In an *HTMLElement-like* structure like a **DaNIS³H Capsule**,  though, an alternative declarative syntax to JSON might prove very useful.

This is where **xHAN** comes in.

**xHAN** uses HTML-like notation and allows for the deployment of indexed, associative and mixed arrays.

**xHAN** also allows for multidimensional arrays of these types.

**xHAN** achieves all of this through the simple expedient of allowing an `=` sign to be followed by unquoted square brackets (`[...]`).

Within the square brackets, comma-separated key-value pairs and lone keys may be nested - and nested within additional unquoted square brackets *to any depth*.

For example the JSON above, written in **xHAN** would look like this:

    myattribute=[[my="sophisticated", data=[structure, is, contained]], [within, this], xHAN]
    
A cursory glance reveals that **xHAN** notation is not radically different from **JSON** notation.

But it *is*, quite intentionally, a little shorter and simpler to write, not least because it is derived from HTML, rather than JavaScript.

## Differences between xHAN and JSON

The main key differences between **xHAN** and **JSON** are:

 - **xHAN** uses an `=` as a key-value separator, instead of `: `
 - **xHAN** only requires quotes around values (while JSON requires quotes around keys *and* values)
 - in **xHAN**, square brackets (`[` and `]`) play double duty, representing the equivalent of both `{}` *and* `[]` in JSON
 - **xHAN** is *visibly* more concise (though it aspires to be as human-readable as JSON)

Beyond these differences, however, the most important difference to note is that **xHAN** allows for *mixed arrays* which are simply not possible in JSON.

## Mixed Arrays in xHAN
