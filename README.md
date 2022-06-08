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

    myattribute='[{"this": "sophisticated", "data": ["structure", "is", "contained"]}, ["within", "this"], "JSON"]'
    
In HTML it's probable that no other approaches are really needed.

## Presenting xHAN: an alternative to using JSON in HTML Attributes

In an *HTMLElement-like* structure like a **DaNIS³H Capsule**,  though, a simple declarative syntax, alternative to JSON, might prove very welcome.

This is where **xHAN** comes in.

 - **xHAN** uses HTML-like notation
 - **xHAN** allows for the deployment of *indexed*, *associative* and *mixed arrays*.
 - **xHAN** also allows for *multidimensional arrays* of these types.

**xHAN** achieves all of this through the simple expedient of allowing an `=` sign to be followed by unquoted square brackets (`[...]`).

Within the square brackets, comma-separated lone keys and key-value pairs may be nested - and they may continue to be nested within unquoted square brackets *to any depth*.

For example the JSON above, written in **xHAN** would look like this:

    myattribute=[[this="sophisticated", data=[structure, is, contained]], [within, this], xHAN]
    
A cursory glance reveals that **xHAN** notation is *not* radically different from **JSON** notation.

But it *is*, quite intentionally, a little shorter and simpler to write, not least because the notation is borrowed from HTML syntax, rather than from JavaScript.

## Key Differences between xHAN and JSON

Key differences between **xHAN** and **JSON** include:

 - **xHAN** uses an `=` as a key-value separator, instead of `: `
 - In **xHAN** quotes around `keys` and `values` are entirely optional. JSON requires quotes around `keys` and `values`. By contrast, **xHAN** can take quotes around `keys` *or* `values` *or* both *or* neither. That is to say, these four examples of **xHAN**:
 - 
   - `[mixedArrayTest=[my="sophisticated", data=[structure, is, contained]], [within, this], xHAN]`
   - `[mixedArrayTest=[my="sophisticated", data=["structure", "is", "contained"]], ["within", "this"], xHAN]`
   - `[mixedArrayTest=[my=sophisticated, data=[structure, is, contained]], [within, this], xHAN]`
   - `["mixedArrayTest"=["my"="sophisticated", "data"=["structure", "is", "contained"]], ["within", "this"], "xHAN"]`
   
   are *functionally identical*
 - square brackets (`[` and `]`) play double duty in **xHAN**, representing the equivalent of both `{}` *and* `[]` in JSON
 - **xHAN** is *visibly* more concise than JSON (though it aspires to be as human-readable as JSON)

## Mixed Data in xHAN

Beyond the key differences above, however, the *most* important difference to note is that **xHAN** is capable of describing and handling *mixed data* which JSON cannot express.

Let's take a look at two examples:

The **xHAN** we used above:

    [[this="sophisticated", data=[structure, is, contained]], [within, this], xHAN]

corresponds neatly and *exactly* with this visually similar **JSON**:

    [{"this": "sophisticated", "data": ["structure", "is", "contained"]}, ["within", "this"], "JSON"]

But *this* more complex **xHAN**:

    [[this=[more="sophisticated"], data=[structure, is, contained]], [within, this], xHAN, which="represents", a, mixed="dataset"]

contains *mixed data*, which JSON, due to its syntactic constraints, cannot handle.

When we write a JSON-like string, visually similar to the **xHAN** above, we quickly see that it ***won't** validate as JSON*:

    [{"this": {"more": "sophisticated"}, "data": ["structure", "is", "contained"]}, ["within", "this"], "JSON", "which": "represents", "a", "mixed": "dataset"]
    
This is because JSON has *two* strictly distinct ways to group related data:

 - JS array-notation data-groups which contain a series of values (`[]`) 
 - JS object-notation data-groups which contains a series of name-value pairs (`{}`)

By contrast, **xHAN** has only **one** way to group related data:

 - *mixed-array data-groups* which can contain a series combining *both* values (e.g. `xHAN`) *and* name-value pairs (e.g. `mixed="dataset"`)

Because of this crucial difference, when you computationally convert the second **xHAN** above into JSON, the conversion delivers the following output:

    {"0.":{"this":{"more":"sophisticated"},"data":["structure","is","contained"]},"1.":["within","this"],"2.":"xHAN","which":"represents","4.":"a","mixed":"dataset"}
    
which *is* valid JSON.

## What is the *point* of xHAN being able to handle mixed data?

It's worth underlining that even though **xHAN** is capable of handling mixed data, most data structures will never usually be written this way.

So, if not, it's reasonable to ask why **xHAN** should be able to handle mixed data at all - especially when JSON doesn't go to these lengths.

The reason is this. If we take a pair of datasets, one **JSON** and one **xHAN**:

 - **JSON:** `{"Mary": "Had", "A": "Little"}`
 - **xHAN:** `[Mary="Had", A="Little"]`

If we wish to add the single value `"Lamb"` to the JSON above, the entire data structure will need some re-arranging:

 - **Invalid JSON:** `{"Mary": "Had", "A": "Little", "Lamb"}`
 - **Valid JSON:** `[{"Mary": "Had", "A": "Little"}, "Lamb"]` *or* `[{"Mary": "Had"}, {"A": "Little"}, "Lamb"]`

By contrast, with **xHAN** we can simply add the value `Lamb` and the **xHAN** remains valid:

- **Valid xHAN:** `[Mary="Had", A="Little", Lamb]`

The **xHAN** above converts to the following JSON:

    {"Mary": "had", "a": "little", "2.": "lamb"}


