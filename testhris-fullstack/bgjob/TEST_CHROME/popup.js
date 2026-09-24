chrome.runtime.sendMessage({ action: "getExtensions" }, function(response) {
    const extensionList = document.getElementById("extensionList");
  
    // Loop through each extension and add it to the list
    response.forEach(extension => {
      const li = document.createElement("li");
      li.textContent = `${extension.name} (ID: ${extension.id})`;
      extensionList.appendChild(li);
    });
  });
  