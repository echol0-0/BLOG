let blogPosts = [];

function createPost(event) {
  event.preventDefault();

  const postTitleInput = document.getElementById("postTitle");
  const postContentInput = document.getElementById("postContent");

  const title = postTitleInput.value;
  const content = postContentInput.value;

  const post = { title, content };
  blogPosts.push(post);

  postTitleInput.value = "";
  postContentInput.value = "";

  generateBlogPosts();
}

function deletePost(index) {
  blogPosts.splice(index, 1);
  generateBlogPosts();
}

function generateBlogPosts() {
  const container = document.getElementById("blogPostsContainer");
  container.innerHTML = "";

  for (let i = 0; i < blogPosts.length; i++) {
    const blogPost = blogPosts[i];
    const title = blogPost.title;
    const content = blogPost.content;

    const blogPostElement = document.createElement("div");
    blogPostElement.className = "blogPost";
    blogPostElement.innerHTML = `
      <h3>${title}</h3>
      <p>${content}</p>
      <button class="deleteButton" onclick="deletePost(${i})">Delete</button>
    `;

    container.appendChild(blogPostElement);
  }
}

const createPostForm = document.getElementById("createPostForm");
createPostForm.addEventListener("submit", createPost);
let votes = [0, 0, 0]; // Array to store vote counts for each option

function vote(option) {
  // Increment the vote count for the selected option
  votes[option]++;

  // Update the vote count display
  let voteCountElement = document.getElementById("voteCount");
  voteCountElement.textContent = "Total votes: " + getTotalVotes();

  // Disable the buttons to prevent multiple votes
  let buttons = document.querySelectorAll("#pollOptions li button");
  buttons.forEach(button => {
    button.disabled = true;
  });
}

function getTotalVotes() {
  // Sum up all the votes
  let totalVotes = votes.reduce((sum, vote) => sum + vote, 0);
  return totalVotes;
}
