hljs.highlightAll();

$.ajax({
    method: 'GET',
    url: BASE_URL + BASE_PATH_API + 'get_all_tags.php',
    xhrFields: {
        withCredentials: true
    },
    dataType: "text",
    success: function(data) {
        $('#snippet-container').append(data);
    }
});

document.getElementById('doc-container').innerHTML =
    marked.parse(`This code is written in Rust and implements the classic FizzBuzz program. Here's a breakdown of how it works:

    **1. \`fn main()\`:**
    
    This line defines the main function, which is the entry point of the program in Rust.
    
    **2. \`for i in 1..101\`:**
    
    This line starts a loop that iterates over a range of numbers. The \`for\` loop iterates over each value of \`i\` from 1 (inclusive) to 101 (exclusive). This means the loop will run 100 times, once for each number between 1 and 100.
    
    **3. \`match (i % 3, i % 5)\`:**
    
    This line uses a \`match\` expression to check the conditions for printing "FizzBuzz", "Fizz", or "Buzz". The \`match\` expression takes a tuple containing the remainders of dividing \`i\` by 3 and 5. These remainders tell us if the number is divisible by 3 or 5.
    
    * \`i % 3\`: This checks if the remainder of dividing \`i\` by 3 is 0. If it is 0, then \`i\` is divisible by 3.
    * \`i % 5\`: This checks if the remainder of dividing \`i\` by 5 is 0. If it is 0, then \`i\` is divisible by 5.
    
    **4. Conditional Printing:**
    
    Inside the \`match\` expression, there are four patterns to match against:
    
    * \`(0, 0)\`: This pattern matches when both remainders are 0. This means \`i\` is divisible by both 3 and 5, so the program prints "FizzBuzz".
    * \`(0, _)\`: This pattern matches when the first remainder (divisible by 3) is 0, and the second remainder doesn't matter. In this case, the program prints "Fizz".
    * \`(_, 0)\`: This pattern matches when the second remainder (divisible by 5) is 0, and the first remainder doesn't matter. Here, the program prints "Buzz".
    * \`_\`: This is the catch-all pattern. If none of the above conditions match, it means \`i\` is not divisible by 3 or 5, so the program simply prints the value of \`i\`.
    
    **5. \`println!\`:**
    
    This line is used to print the output to the console. The specific content printed depends on which pattern in the \`match\` expression matches.
    
    In summary, this code iterates through numbers 1 to 100 and prints "FizzBuzz" for numbers divisible by both 3 and 5, "Fizz" for numbers divisible by 3 only, "Buzz" for numbers divisible by 5 only, and the number itself for all other cases.`);