title: POSIX basic and extended
categories: [程序设计,操作系统,Linux,C编程]
tags: []
date: 2014-02-25 22:22:36
---
<strong>引用：http://en.wikipedia.org/wiki/Regular_expression</strong>
<h4>POSIX basic and extended[<a title="Edit section: POSIX basic and extended" href="http://en.wikipedia.org/w/index.php?title=Regular_expression&amp;action=edit&amp;section=10">edit</a>]</h4>
In the <a title="POSIX" href="http://en.wikipedia.org/wiki/POSIX">POSIX</a> standard, Basic Regular Syntax, BRE, requires that the <a title="Metacharacter" href="http://en.wikipedia.org/wiki/Metacharacter">metacharacters</a> ( ) and { } be designated () and {}, whereas Extended Regular Syntax, ERE, does not.
<table>
<tbody>
<tr>
<th>Metacharacter</th>
<th>Description</th>
</tr>
<tr valign="top">
<th>.</th>
<td>Matches any single character (many applications exclude <a title="Newline" href="http://en.wikipedia.org/wiki/Newline">newlines</a>, and exactly which characters are considered newlines is flavor-, character-encoding-, and platform-specific, but it is safe to assume that the line feed character is included). Within POSIX bracket expressions, the dot character matches a literal dot. For example, a.c matches "abc", etc., but [a.c] matches only "a", ".", or "c".</td>
</tr>
<tr valign="top">
<th>[ ]</th>
<td>A bracket expression. Matches a single character that is contained within the brackets. For example, [abc] matches "a", "b", or "c". [a-z]specifies a range which matches any lowercase letter from "a" to "z". These forms can be mixed: [abcx-z] matches "a", "b", "c", "x", "y", or "z", as does [a-cx-z].The - character is treated as a literal character if it is the last or the first (after the ^, if present) character within the brackets: [abc-], [-abc]. Note that backslash escapes are not allowed. The ] character can be included in a bracket expression if it is the first (after the ^) character: []abc].</td>
</tr>
<tr valign="top">
<th>[^ ]</th>
<td>Matches a single character that is not contained within the brackets. For example, [^abc] matches any character other than "a", "b", or "c".[^a-z] matches any single character that is not a lowercase letter from "a" to "z". Likewise, literal characters and ranges can be mixed.</td>
</tr>
<tr valign="top">
<th>^</th>
<td>Matches the starting position within the string. In line-based tools, it matches the starting position of any line.</td>
</tr>
<tr valign="top">
<th>$</th>
<td>Matches the ending position of the string or the position just before a string-ending newline. In line-based tools, it matches the ending position of any line.</td>
</tr>
<tr valign="top">
<th>( )</th>
<td>Defines a marked subexpression. The string matched within the parentheses can be recalled later (see the next entry, <i>n</i>). A marked subexpression is also called a block or capturing group. <b>BRE mode requires ( )</b>.</td>
</tr>
<tr valign="top">
<th><i>n</i></th>
<td>Matches what the <i>n</i>th marked subexpression matched, where <i>n</i> is a digit from 1 to 9. This construct is vaguely defined in the POSIX.2 standard. Some tools allow referencing more than nine capturing groups.</td>
</tr>
<tr valign="top">
<th>*</th>
<td>Matches the preceding element zero or more times. For example, ab*c matches "ac", "abc", "abbbc", etc. [xyz]* matches "", "x", "y", "z", "zx", "zyx", "xyzzy", and so on. (ab)* matches "", "ab", "abab", "ababab", and so on.</td>
</tr>
<tr valign="top">
<th>{<i>m</i>,<i>n</i>}</th>
<td>Matches the preceding element at least <i>m</i> and not more than <i>n</i> times. For example, a{3,5} matches only "aaa", "aaaa", and "aaaaa". This is not found in a few older instances of regular expressions. <b>BRE mode requires {<i>m</i>,<i>n</i>}</b>.</td>
</tr>
</tbody>
</table>
<b>Examples:</b>
<ul>
	<li>.at matches any three-character string ending with "at", including "hat", "cat", and "bat".</li>
	<li>[hc]at matches "hat" and "cat".</li>
	<li>[^b]at matches all strings matched by .at except "bat".</li>
	<li>[^hc]at matches all strings matched by .at other than "hat" and "cat".</li>
	<li>^[hc]at matches "hat" and "cat", but only at the beginning of the string or line.</li>
	<li>[hc]at$ matches "hat" and "cat", but only at the end of the string or line.</li>
	<li>[.] matches any single character surrounded by "[" and "]" since the brackets are escaped, for example: "[a]" and "[b]".</li>
	<li>s.* matches any number of characters preceded by s , for example: "saw" and "seed".</li>
</ul>
<h4>POSIX extended[<a title="Edit section: POSIX extended" href="http://en.wikipedia.org/w/index.php?title=Regular_expression&amp;action=edit&amp;section=11">edit</a>]</h4>
The meaning of metacharacters <a title="Escape sequence" href="http://en.wikipedia.org/wiki/Escape_sequence">escaped</a> with a backslash is reversed for some characters in the POSIX Extended Regular Expression (ERE) syntax. With this syntax, a backslash causes the metacharacter to be treated as a literal character. So, for example, ( ) is now ( ) and { } is now { }. Additionally, support is removed for <i>n</i> backreferences and the following metacharacters are added:
<table>
<tbody>
<tr>
<th>Metacharacter</th>
<th>Description</th>
</tr>
<tr valign="top">
<th>?</th>
<td>Matches the preceding element zero or one time. For example, ab?c matches only "ac" or "abc".</td>
</tr>
<tr>
<th>+</th>
<td>Matches the preceding element one or more times. For example, ab+c matches "abc", "abbc", "abbbc", and so on, but not "ac".</td>
</tr>
<tr>
<th>|</th>
<td>The choice (also known as alternation or set union) operator matches either the expression before or the expression after the operator. For example, abc|def matches "abc" or "def".</td>
</tr>
</tbody>
</table>
<b>Examples:</b>
<ul>
	<li>[hc]+at matches "hat", "cat", "hhat", "chat", "hcat", "cchchat", and so on, but not "at".</li>
	<li>[hc]?at matches "hat", "cat", and "at".</li>
	<li>[hc]*at matches "hat", "cat", "hhat", "chat", "hcat", "cchchat", "at", and so on.</li>
	<li>cat|dog matches "cat" or "dog".</li>
</ul>
POSIX Extended Regular Expressions can often be used with modern Unix utilities by including the <a title="Command line" href="http://en.wikipedia.org/wiki/Command_line">command line</a> flag <var>-E</var>.
<h4>Character classes[<a title="Edit section: Character classes" href="http://en.wikipedia.org/w/index.php?title=Regular_expression&amp;action=edit&amp;section=12">edit</a>]</h4>
The character class is the most basic regular expression concept after a literal match. It makes one small sequence of characters match a larger set of characters. For example, [A-Z] could stand for the alphabet, and d could mean any digit. Character classes apply to both POSIX levels.
When specifying a range of characters, such as [a-Z] computer's locale settings determine the contents by the numeric ordering of the character encoding. They could store digits in that sequence, or the ordering could be <i>abc...zABC...Z</i>, or <i>aAbBcC...zZ</i>. So the POSIX standard defines a character class, which will be known by the regular expression processor installed. Those definitions are in the following table:
<table>
<tbody>
<tr>
<th>POSIX</th>
<th>Non-standard</th>
<th>Perl/Tcl</th>
<th>Vim</th>
<th>ASCII</th>
<th>Description</th>
</tr>
<tr>
<td>[:alnum:]</td>
<td></td>
<td></td>
<td></td>
<td>[A-Za-z0-9]</td>
<td>Alphanumeric characters</td>
</tr>
<tr>
<td></td>
<td>[:word:]</td>
<td>w</td>
<td>w</td>
<td>[A-Za-z0-9_]</td>
<td>Alphanumeric characters plus "_"</td>
</tr>
<tr>
<td></td>
<td></td>
<td>W</td>
<td>W</td>
<td>[^A-Za-z0-9_]</td>
<td>Non-word characters</td>
</tr>
<tr>
<td>[:alpha:]</td>
<td></td>
<td></td>
<td>a</td>
<td>[A-Za-z]</td>
<td>Alphabetic characters</td>
</tr>
<tr>
<td>[:blank:]</td>
<td></td>
<td></td>
<td>s</td>
<td>[ <a title="t" href="http://en.wikipedia.org/wiki/%5Ct">t</a>]</td>
<td>Space and tab</td>
</tr>
<tr>
<td></td>
<td></td>
<td>b</td>
<td>&lt; &gt;</td>
<td>(?&lt;=W)(?=w)|(?&lt;=w)(?=W)</td>
<td>Word boundaries</td>
</tr>
<tr>
<td>[:cntrl:]</td>
<td></td>
<td></td>
<td></td>
<td>[x00-x1Fx7F]</td>
<td><a title="Control character" href="http://en.wikipedia.org/wiki/Control_character">Control characters</a></td>
</tr>
<tr>
<td>[:digit:]</td>
<td></td>
<td>d</td>
<td>d</td>
<td>[0-9]</td>
<td>Digits</td>
</tr>
<tr>
<td></td>
<td></td>
<td>D</td>
<td>D</td>
<td>[^0-9]</td>
<td>Non-digits</td>
</tr>
<tr>
<td>[:graph:]</td>
<td></td>
<td></td>
<td></td>
<td>[x21-x7E]</td>
<td>Visible characters</td>
</tr>
<tr>
<td>[:lower:]</td>
<td></td>
<td></td>
<td>l</td>
<td>[a-z]</td>
<td>Lowercase letters</td>
</tr>
<tr>
<td>[:print:]</td>
<td></td>
<td></td>
<td>p</td>
<td>[x20-x7E]</td>
<td>Visible characters and the space character</td>
</tr>
<tr>
<td>[:punct:]</td>
<td></td>
<td></td>
<td></td>
<td>[][!"#$%&amp;'()*+,./:;&lt;=&gt;?@^_`{|}~-]</td>
<td>Punctuation characters</td>
</tr>
<tr>
<td>[:space:]</td>
<td></td>
<td>s</td>
<td>_s</td>
<td>[ <a title="t" href="http://en.wikipedia.org/wiki/%5Ct">t</a><a title="r" href="http://en.wikipedia.org/wiki/%5Cr">r</a><a title="n" href="http://en.wikipedia.org/wiki/%5Cn">n</a><a title="v" href="http://en.wikipedia.org/wiki/%5Cv">v</a><a title="f" href="http://en.wikipedia.org/wiki/%5Cf">f</a>]</td>
<td><a title="Whitespace character" href="http://en.wikipedia.org/wiki/Whitespace_character">Whitespace characters</a></td>
</tr>
<tr>
<td></td>
<td></td>
<td>S</td>
<td></td>
<td>[^ trnvf]</td>
<td>Non-whitespace characters</td>
</tr>
<tr>
<td>[:upper:]</td>
<td></td>
<td></td>
<td>u</td>
<td>[A-Z]</td>
<td>Uppercase letters</td>
</tr>
<tr>
<td>[:xdigit:]</td>
<td></td>
<td></td>
<td>x</td>
<td>[A-Fa-f0-9]</td>
<td>Hexadecimal digits</td>
</tr>
</tbody>
</table>
POSIX character classes can only be used within bracket expressions. For example, [[:upper:]ab] matches the uppercase letters and lowercase "a" and "b".
An additional non-POSIX class understood by some tools is [:word:], which is usually defined as [:alnum:] plus underscore. This reflects the fact that in many programming languages these are the characters that may be used in identifiers. The editor <a title="Vim (text editor)" href="http://en.wikipedia.org/wiki/Vim_(text_editor)">Vim</a> further distinguishes <i>word</i> and <i>word-head</i> classes (using the notation w and h) since in many programming languages the characters that can begin an identifier are not the same as those that can occur in other positions.
Note that what the POSIX regular expression standards call <i>character classes</i> are commonly referred to as <i>POSIX character classes</i> in other regular expression flavors which support them. With most other regular expression flavors, the term <i>character class</i> is used to describe what POSIX calls <i>bracket expressions</i>.
C默认在*NIX下面，可以使用这些规则，最基本的POSIX语法，不需要其他的扩展库。