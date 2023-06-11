# Air Pollution Visualization Web App

This web application was developed as a project for a bachelor's degree, aiming to provide air pollution visualization from different heights and positions using technologies such as Laravel, Blade, TailwindCSS, Chart.js, CesiumJS, OpenWeather API, and Leaflet.js.

## Features

- Air pollution visualization from different heights and positions
- Validation of uploaded files:
  - Files must be in CSV format
  - Files need to have required data columns
  - Files must have matching time rows
- Importing of uploaded CSV files to the database using Laravel Excel package
- Exporting of the collected drone and Arduino sensor data into an single Excel file for further analysis
- Visualization of imported data:
  - Data displayed in tables showing the 5 biggest pollution points
  - Display of maximum, minimum, and average pollution levels
  - Display of flight time, average temperature, and humidity
- Integration with OpenWeather API to retrieve pollution information for recorded locations during flights
- Visualization of Air Quality Index (AQI) and pollutant levels using color-coded cards
- Generation of diagrams using Chart.js based on collected air pollution data for each pollutant
- Map display using Leaflet.js with an air pollution grid:
  - Grid squares are colored based on the average air pollution in each square
  - Clickable grid squares display information about the average pollution and altitude of the record
- Wind direction vector layer on the map, displaying wind speed information
- Cesium integration for drawing drone flight lines in 3D:
  - Flight lines are colored based on the air pollution at each position
  - Hovering over the line displays air pollution level, altitude, and coordinates at that point
- Admin role with additional privileges to edit and delete generated visualizations

## Usage

1. Register a new user account or log in with an existing account.
2. Upload two CSV files containing air pollution data collected by the drone and Arduino sensors.
   - Ensure that the files are in the required CSV format and have the necessary data columns.
   - The files must have matching time rows.
   - The app will validate the files before importing them into the database.
3. Once the files are imported, the web app will display the visualization of the air pollution data.
   - You can explore the data in tables, which show the 5 biggest pollution points, maximum, minimum, and average pollution levels, flight time, average temperature, and humidity.
   - The OpenWeather API integration provides additional pollution information for recorded locations during flights.
   - The app also generates diagrams using Chart.js based on the collected air pollution data for each pollutant.
   - The map view, powered by Leaflet.js, displays an air pollution grid with color-coded squares representing the average air pollution in each square.
     - Clicking on a square will show information about the average pollution and altitude of the record.
   - The map also includes a wind direction vector layer from API and displays the wind speed.
   - Using Cesium, the app draws the drone flight line in 3D, which is colored based on the air pollution at each position.
     - Hovering over the line will display the air pollution level, altitude, and coordinates at that point.
4. If you have an admin role, you can edit and delete the generated visualizations as needed.


![screencapture-127-0-0-1-8000-ataskaitos-21-2023-06-11-23_55_12](https://github.com/Tpexas/Different-altitude-air-pollution-data-visualization-web-app/assets/103386420/e0651939-6c2a-4bdf-af48-f8116772f22b)
![Ekrano nuotrauka 2023-06-11 235616](https://github.com/Tpexas/Different-altitude-air-pollution-data-visualization-web-app/assets/103386420/a2e9286e-26b9-409d-8faf-49f2dedc9a67)
![Ekrano nuotrauka 2023-06-11 235403](https://github.com/Tpexas/Different-altitude-air-pollution-data-visualization-web-app/assets/103386420/6d08e695-ebe9-441f-8eed-3eddff12e6a0)
![Ekrano nuotrauka 2023-06-11 235759](https://github.com/Tpexas/Different-altitude-air-pollution-data-visualization-web-app/assets/103386420/2f2aff3c-aed2-4ec2-bea6-6e75d0a8741d)
![database](https://github.com/Tpexas/Different-altitude-air-pollution-data-visualization-web-app/assets/103386420/5512378b-c99d-4bd8-8888-a3b9c1d0b4bd)
![Ekrano nuotrauka 2023-06-12 000348](https://github.com/Tpexas/Different-altitude-air-pollution-data-visualization-web-app/assets/103386420/e33f8737-4d95-40a1-b379-606de68cbb82)
![Ekrano nuotrauka 2023-06-12 000606](https://github.com/Tpexas/Different-altitude-air-pollution-data-visualization-web-app/assets/103386420/d3bca41f-2453-486e-b112-cec195b46a27)
