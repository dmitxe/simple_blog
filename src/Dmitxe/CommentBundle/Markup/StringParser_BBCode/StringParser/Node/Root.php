<?php
/**
 * BB code string parsing class
 *
 * Version: 0.3.3
 *
 * @author Christian Seiler <spam@christian-seiler.de>
 * @copyright Christian Seiler 2004-2008
 * @package stringparser
 *
 * The MIT License
 *
 * Copyright (c) 2004-2008 Christian Seiler
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

/**
 * String parser root node class
 *
 * @package stringparser
 */
class StringParser_Node_Root extends StringParser_Node {
	/**
	 * The type of this node.
	 *
	 * This node is a root node.
	 *
	 * @access protected
	 * @var int
	 * @see STRINGPARSER_NODE_ROOT
	 */
	var $_type = STRINGPARSER_NODE_ROOT;
}