<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>笔记</title>
<style>
* {
    box-sizing: border-box;
}
html,
body {
    height: 100%;
}

body {
    margin: 0;
    padding: 0;
}

.container {
    position: relative;
    width: 100%;
    height: 100%;
}

#note-index {
    float: left;
    border-right: 1px solid #CCC;
    width: 200px;
    height: 100%;
}

#note-index ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

#note-index ul li {
    border-bottom: 1px solid #CCC;
    padding: 0.5em 1em;
}

#note-index ul li:first-child {
    padding-top: 1em;
}

#editor-container {
    display: absolute;
    margin-left: 200px;
    background: #999;
    height: 100%;
}

#editor-container textarea{
    display: block;
    width: 100%;
    height: 100%;
    font-size: 1em;
    border: 0;
    padding: 1em;
    margin: 0;
    outline: none;
}
</style>
</head>
<body>

    <div class="container">

        <section id="note-index">
            <ul>
                <li><a href="#">文章标题1</a></li>
                <li><a href="#">文章标题1</a></li>
                <li><a href="#">文章标题1</a></li>
                <li><a href="#">文章标题1</a></li>
                <li><a href="#">文章标题1</a></li>
                <li><a href="#">文章标题1</a></li>
                <li><a href="#">文章标题1</a></li>
                <li><a href="#">文章标题1</a></li>
                <li><a href="#">文章标题1</a></li>
                <li><a href="#">文章标题1</a></li>
                <li><a href="#">文章标题1</a></li>
            </ul>
        </section>

        <div id="editor-container">
            <textarea name="content"></textarea>
        </div>

    </div>

</body>
</html>
