/**
 * The `message` event is fired in a web worker any time `worker.postMessage(<data>)` is called.
 * `event.data` represents the data being passed into a worker via `worker.postMessage(<data>)`.
 */
self.addEventListener('message', async (event) => {
	const {path: imageURL, index: positionIndex } = event?.data;
	const response = await fetch(imageURL);
	const blob = await response.blob();
	const bitmap = await createImageBitmap(blob);

	/** Send the image data back to the UI thread */
	self.postMessage({ bitmap, positionIndex });
});