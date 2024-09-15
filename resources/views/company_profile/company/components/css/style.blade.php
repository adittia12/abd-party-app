<style>
    #features-tab-list {
        display: flex;
        justify-content: center;
        gap: 1rem;
        /* Adjusts the spacing between the cards */
    }

    #features-tab-list .nav-item {
        flex: 1 1 auto;
        /* Allows items to resize */
        max-width: 160px;
        /* Restricts the maximum width */
        text-align: center;
        /* Centers the content */
    }

    .uniform-image {
        width: 100%;
        /* Makes the image responsive */
        height: 200px;
        /* Sets a fixed height */
        object-fit: cover;
        /* Ensures the image covers the area without stretching */
        border-radius: 8px;
        /* Optional: adds rounded corners */
    }

    .service-list {
        list-style: none;
        /* Remove default list styling */
        padding: 0;
        /* Remove padding */
        margin: 20px 0;
        /* Add top and bottom margins */
    }

    .service-list li {
        display: flex;
        /* Use flexbox for horizontal alignment */
        align-items: flex-start;
        /* Align items to the start for proper icon alignment */
        margin-bottom: 20px;
        /* Space between list items */
        padding: 15px;
        /* Add padding for a spacious look */
        border-radius: 8px;
        /* Rounded corners for the list items */
        background-color: #f8f9fa;
        /* Light background for better visual separation */
    }

    .service-list i {
        color: #0d6efd;
        /* Icon color */
        font-size: 24px;
        /* Increase icon size */
        margin-right: 15px;
        /* Space between icon and text */
        margin-top: 4px;
        /* Adjust icon's vertical alignment */
    }

    .service-list .description {
        margin: 5px 0 0 0;
        /* Space between title and description */
        color: #6c757d;
        /* Subtle color for the description */
        font-size: 0.95rem;
        /* Adjust font size */
        line-height: 1.6;
        /* Improve readability */
    }

    /* Title styling */
    .service-list li>span {
        font-size: 1rem;
        /* Title font size */
        font-weight: 600;
        /* Bold title */
        color: #333;
        /* Darker color for the title */
    }

    /* Styling the container */
    .skills-list-container {
        background-color: #f5f7fa;
        /* Light background for the container */
        padding: 20px;
        /* Padding around the list */
        border-radius: 10px;
        /* Rounded corners */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        /* Subtle shadow for depth */
    }

    /* Styling the heading */
    .skills-list-container h3 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 20px;
        /* Space between the title and list */
    }

    /* Styling the list */
    .skills-list {
        list-style: none;
        /* Remove default list styling */
        padding: 0;
        /* Remove default padding */
        margin: 0;
        /* Remove default margin */
    }

    /* Individual list items */
    .skills-list li {
        display: flex;
        /* Use flexbox for alignment */
        align-items: center;
        /* Vertically center the content */
        margin-bottom: 15px;
        /* Space between list items */
        padding: 10px 15px;
        /* Padding inside each list item */
        background-color: #ffffff;
        /* Background color for each item */
        border-radius: 8px;
        /* Rounded corners */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        /* Smooth hover effect */
    }

    /* Hover effect for list items */
    .skills-list li:hover {
        transform: translateY(-5px);
        /* Slight lift on hover */
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
        /* Add shadow on hover */
    }

    /* Icon styling */
    .skills-list i {
        color: #0d6efd;
        /* Primary color for the icon */
        font-size: 20px;
        /* Adjust icon size */
        margin-right: 15px;
        /* Space between the icon and text */
    }

    /* Text styling */
    .skills-list li span {
        font-size: 1rem;
        /* Font size for the skill text */
        color: #555;
        /* Text color */
    }

    /* Alert message styling */
    .alert {
        margin-top: 20px;
        /* Space above the alert */
        font-size: 1rem;
        /* Adjust font size */
        text-align: center;
        /* Center the alert text */
        border-radius: 8px;
        /* Rounded corners */
    }

    /* Styling the container */
    .service-area-container {
        background-color: #f8f9fa;
        /* Light background for the container */
        padding: 30px;
        /* Padding around the content */
        border-radius: 12px;
        /* Rounded corners */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        /* Subtle shadow for depth */
    }

    /* Styling the heading */
    .service-area-container h3 {
        font-size: 1.8rem;
        /* Increase font size */
        font-weight: bold;
        /* Bold text */
        color: #333;
        /* Darker color for the heading */
        margin-bottom: 20px;
        /* Space below the heading */
        border-bottom: 2px solid #0d6efd;
        /* Add an underline */
        display: inline-block;
        /* Inline-block to fit the underline */
        padding-bottom: 5px;
        /* Padding for the underline */
    }

    /* Styling the list */
    .service-list {
        list-style: none;
        /* Remove default list styling */
        padding: 0;
        /* Remove padding */
        margin: 0;
        /* Remove margin */
    }

    /* Individual list items */
    .service-list li {
        display: flex;
        /* Use flexbox for alignment */
        align-items: center;
        /* Vertically align items */
        margin-bottom: 15px;
        /* Space between list items */
        padding: 15px;
        /* Padding inside each item */
        background-color: #ffffff;
        /* White background for items */
        border-radius: 8px;
        /* Rounded corners */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        /* Smooth hover effect */
    }

    /* Hover effect for list items */
    .service-list li:hover {
        transform: translateY(-5px);
        /* Slight lift on hover */
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        /* Add shadow on hover */
    }

    /* Icon styling */
    .service-list i {
        color: #0d6efd;
        /* Primary color for icons */
        font-size: 24px;
        /* Increase icon size */
        margin-right: 15px;
        /* Space between icon and text */
    }

    /* Text styling */
    .service-list li span {
        font-size: 1rem;
        /* Font size for the text */
        color: #555;
        /* Text color */
        font-weight: 500;
        /* Medium font weight */
    }

    /* Alert message styling */
    .alert {
        margin-top: 20px;
        /* Space above the alert */
        font-size: 1rem;
        /* Adjust font size */
        text-align: center;
        /* Center the alert text */
        border-radius: 8px;
        /* Rounded corners */
    }

    /* Styling the container */
    .service-area-container {
        background-color: #f8f9fa;
        /* Light background for the container */
        padding: 30px;
        /* Padding around the content */
        border-radius: 12px;
        /* Rounded corners */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        /* Subtle shadow for depth */
    }

    /* Styling the heading */
    .service-area-container h3 {
        font-size: 1.8rem;
        /* Increase font size */
        font-weight: bold;
        /* Bold text */
        color: #333;
        /* Darker color for the heading */
        margin-bottom: 20px;
        /* Space below the heading */
        border-bottom: 2px solid #0d6efd;
        /* Add an underline */
        display: inline-block;
        /* Inline-block to fit the underline */
        padding-bottom: 5px;
        /* Padding for the underline */
    }

    /* Styling the list */
    .service-list {
        list-style: none;
        /* Remove default list styling */
        padding: 0;
        /* Remove padding */
        margin: 0;
        /* Remove margin */
    }

    /* Individual list items */
    .service-list li {
        display: flex;
        /* Use flexbox for alignment */
        align-items: center;
        /* Vertically align items */
        margin-bottom: 15px;
        /* Space between list items */
        padding: 15px;
        /* Padding inside each item */
        background-color: #ffffff;
        /* White background for items */
        border-radius: 8px;
        /* Rounded corners */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        /* Smooth hover effect */
    }

    /* Hover effect for list items */
    .service-list li:hover {
        transform: translateY(-5px);
        /* Slight lift on hover */
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        /* Add shadow on hover */
    }

    /* Icon styling */
    .service-list i {
        color: #0d6efd;
        /* Primary color for icons */
        font-size: 24px;
        /* Increase icon size */
        margin-right: 15px;
        /* Space between icon and text */
    }

    /* Text styling */
    .service-list li span {
        font-size: 1rem;
        /* Font size for the text */
        color: #555;
        /* Text color */
        font-weight: 500;
        /* Medium font weight */
    }

    /* Alert message styling */
    .alert {
        margin-top: 20px;
        /* Space above the alert */
        font-size: 1rem;
        /* Adjust font size */
        text-align: center;
        /* Center the alert text */
        border-radius: 8px;
        /* Rounded corners */
    }

    /* Portfolio item container */
    .portfolio-item {
        position: relative;
        overflow: hidden;
        /* Hide overflow */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        /* Subtle shadow */
        transition: transform 0.3s ease;
        /* Smooth hover effect */
    }

    /* Hover effect */
    .portfolio-item:hover {
        transform: scale(1.05);
    }

    /* Image styling */
    .portfolio-content img {
        width: 100%;
        /* Full width of the container */
        height: 250px;
        /* Fixed height for uniformity */
        object-fit: cover;
        /* Maintain aspect ratio and crop if necessary */
        transition: opacity 0.3s ease;
        /* Smooth transition */
    }

    /* Portfolio info overlay */
    .portfolio-info {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        /* Semi-transparent overlay */
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        /* Smooth fade-in */
    }

    /* Show overlay on hover */
    .portfolio-item:hover .portfolio-info {
        opacity: 1;
    }

    /* Icon styling in overlay */
    .portfolio-info i {
        font-size: 2rem;
        color: #ffffff;
        transition: transform 0.3s ease;
    }

    .portfolio-info i:hover {
        transform: scale(1.2);
        /* Slightly enlarge icon on hover */
    }

    /* Responsive styling */
    @media (max-width: 768px) {
        .portfolio-item {
            margin-bottom: 20px;
            /* Space between items on smaller screens */
        }
    }


    /* Google Maps */
    .mb-5 iframe {
        border: 0;
        /* Remove default border */
        border-radius: 10px;
        /* Rounded corners */
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        /* Subtle shadow for depth */
    }

    /* Contact Info */
    .info {
        background-color: #f8f9fa;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .info h3 {
        font-size: 1.8rem;
        font-weight: 600;
        margin-bottom: 20px;
        color: #333;
    }

    .info p {
        font-size: 1rem;
        color: #666;
        margin-bottom: 20px;
    }

    .info-item {
        margin-bottom: 20px;
        display: flex;
        align-items: flex-start;
    }

    .info-item i {
        font-size: 1.8rem;
        color: #007bff;
        /* Use your primary color */
        margin-right: 15px;
    }

    .info-item h4 {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .info-item p {
        font-size: 1rem;
        color: #555;
    }

    /* Contact Form */
    form {
        background-color: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .form-group input,
    .form-group textarea {
        border: 1px solid #ced4da;
        padding: 15px;
        border-radius: 5px;
        transition: border-color 0.3s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        border-color: #007bff;
        /* Highlight border on focus */
    }

    .text-danger {
        font-size: 0.875rem;
        margin-top: 5px;
    }

    /* Submit Button */
    .text-center .btn {
        background-color: #007bff;
        color: #fff;
        padding: 12px 30px;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .text-center .btn:hover {
        background-color: #0056b3;
    }

    /* Footer Top */
    .footer-top {
        background-color: #343a40;
        /* Dark background */
        color: #ffffff;
        /* White text */
        padding: 40px 0;
        /* Padding for spacing */
    }

    .footer-top .logo {
        font-size: 1.8rem;
        /* Larger font size for the logo */
        font-weight: bold;
        color: #ffffff;
        text-decoration: none;
    }

    .footer-top .sitename {
        color: #007bff;
        /* Primary accent color */
    }

    .footer-top .footer-contact p {
        margin-bottom: 10px;
        /* Spacing between contact details */
        color: #cccccc;
        /* Lighter color for the text */
    }

    .footer-top .footer-contact a {
        color: #00aaff;
        /* Accent color for links */
        text-decoration: none;
        transition: color 0.3s ease;
        /* Smooth transition */
    }

    .footer-top .footer-contact a:hover {
        color: #ffaa00;
        /* Hover color */
    }

    /* Copyright Section */
    .copyright {
        background-color: #212529;
        /* Slightly darker background */
        color: #777777;
        /* Light gray text color */
        padding: 20px 0;
        /* Padding for spacing */
        font-size: 0.875rem;
        /* Slightly smaller font size */
    }

    .copyright a {
        color: #00aaff;
        /* Accent color for links */
        text-decoration: none;
        transition: color 0.3s ease;
        /* Smooth transition */
    }

    .copyright a:hover {
        color: #ffaa00;
        /* Hover color */
    }

    /* Social Links */
    .social-links a {
        color: #00aaff;
        /* Primary color for social icons */
        font-size: 1.5rem;
        /* Larger icons */
        margin: 0 10px;
        /* Spacing between icons */
        transition: color 0.3s ease;
        /* Smooth transition */
    }

    .social-links a:hover {
        color: #ffaa00;
        /* Hover color */
    }
</style>
