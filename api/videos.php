<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Videos & Reviews</title>
  <style>
    body { 
      font-family: Arial, sans-serif; 
      background: #f9f9f9; 
      padding: 40px 20px; 
      margin: 0;
    }
    h1 { 
      text-align: center; 
      margin-bottom: 40px; 
      color: #333;
    }
    .videos-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
      gap: 25px;
      max-width: 1400px;
      margin: 0 auto;
    }
    .video-card {
      background: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      transition: transform 0.3s;
    }
    .video-card:hover { 
      transform: translateY(-8px); 
    }
    .thumbnail {
      position: relative;
      width: 100%;
    }
    .thumbnail img {
      width: 100%;
      height: 200px;
      object-fit: cover;
    }
    .info {
      padding: 15px;
    }
    .title {
      font-size: 16px;
      font-weight: 600;
      margin: 0 0 8px 0;
      line-height: 1.3;
      color: #222;
    }
    .meta {
      color: #666;
      font-size: 14px;
    }
  </style>
</head>
<body>

  <h1>Videos & Reviews</h1>

  <div class="videos-grid" id="videos-grid">
    <!-- Videos will load here -->
  </div>

  <script>
     const channelId = 'UCBvOhii-3p-BBaJaMPIHEAA';  
    const apiKey = 'AIzaSyANRTbHANRvsBL-9dPWZN3fSvbaIZhX1Ig';   
    

    const grid = document.getElementById('videos-grid');

    fetch(`https://www.googleapis.com/youtube/v3/search?key=${apiKey}&channelId=${channelId}&part=snippet,id&order=date&type=video&maxResults=50`)
      .then(response => {
        if (!response.ok) {
          throw new Error(`API Error: ${response.status} - Check your Channel ID and API Key`);
        }
        return response.json();
      })
      .then(data => {
        grid.innerHTML = '';

        if (!data.items || data.items.length === 0) {
          grid.innerHTML = '<p style="text-align:center; grid-column:1/-1;">No videos found.</p>';
          return;
        }

        data.items.forEach(item => {
          const videoId = item.id.videoId;
          const title = item.snippet.title;
          const thumbnail = item.snippet.thumbnails.medium.url;
          const published = new Date(item.snippet.publishedAt).toLocaleDateString('en-US', {
            year: 'numeric', 
            month: 'short', 
            day: 'numeric'
          });

          const card = `
            <div class="video-card">
              <a href="https://www.youtube.com/watch?v=${videoId}" target="_blank" style="text-decoration: none; color: inherit;">
                <div class="thumbnail">
                  <img src="${thumbnail}" alt="${title}">
                </div>
                <div class="info">
                  <h3 class="title">${title}</h3>
                  <p class="meta">New • ${published}</p>
                </div>
              </a>
            </div>`;
          
          grid.innerHTML += card;
        });
      })
      .catch(err => {
        console.error(err);
        grid.innerHTML = `
          <p style="color: red; text-align: center; grid-column: 1 / -1; padding: 20px;">
            ❌ Failed to load videos.<br><br>
            ${err.message}<br><br>
            Please check your Channel ID and API Key.
          </p>`;
      });
  </script>
</body>
</html>