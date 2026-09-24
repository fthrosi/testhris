chrome.management.getAll(function(extensions) {
    // Logging the list of extensions to the console
    console.log("Installed Extensions:", extensions);
  
    // Send the list to the popup or other parts of your extension
    chrome.runtime.onMessage.addListener((request, sender, sendResponse) => {
      if (request.action === "getExtensions") {
        sendResponse(extensions);
      }
    });
  });
  