## Lexi's Perspective Endpoint
#### This is a custom endpoint handler for Google's PerspectAPI.
This API uses PHP only. It can be hosted anywhere as long as the server supports PHP. You can configure a Key if you want to host your fork of the API publicly.
This is not a way to use PerspectiveAPI for free. It still requires a token, and i cannot provide a token.

#### Parameters
- msg = The message input
- mode = The mode of PerspectiveAPI you wish to request for.
- key (optional) = The authorization key in order to use the API
- token = Your token for PerspectiveAPI
- b64 (optional, default 0) = determine if you wish to have base64 decoding on your msg parameter.
You will configure these parameters in a GET request. [To learn more about PerspectiveAPI click here.](https://developers.perspectiveapi.com/)

Here is an example query.
```javascript
{
  "info": {
    "title": "Lexi's Perspective Endpoint",
    "version": "1.0.0",
    "about": "This is a custom endpoint handler for Google's PerspectAPI.",
    "tos": "By using this API you agree to Google's ToS."
  },
  "api": {
    "mode": "TOXICITY",
    "input": "Hello World",
    "result": 4,
    "error": null
  }
}
```

As you can see, it returned a "Result" this is your percentage of probability.
You are free to modify everything about the API, **except what is explicitly told not to be edited.**

This is my first github repo, so i hope you enjoy it.
~Lex
