package com.mycompany.gui;

import com.codename1.ui.Button;
import com.codename1.ui.Container;
import com.codename1.ui.Font;
import com.codename1.ui.Form;
import com.codename1.ui.Label;
import com.codename1.ui.TextField;
import com.codename1.ui.Toolbar;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.util.Resources;




//import org.json.JSONArray;
//import org.json.JSONObject;

public class ListServices {
/*
    private Form form;
    private Container searchResultsContainer;

    public ListServices(Resources res) {
        form = new Form("Search Applications");
        
        Toolbar tb = new Toolbar(true);
        form.setToolbar(tb);
        form.getTitleArea().setUIID("Container");
        form.getContentPane().setScrollVisible(false);
        
        tb.addSearchCommand(e -> {
            // TODO: Handle search from toolbar
        });

        // Create text fields for x and y
       TextField xField = new TextField("", "Location", 20, TextField.ANY);
xField.getAllStyles().setFgColor(0x000000); // set foreground color to black
xField.getUnselectedStyle().setFgColor(0x000000);
TextField yField = new TextField("", "Role", 20, TextField.ANY);
  yField.getAllStyles().setFgColor(0x000000); // set foreground color to black
yField.getUnselectedStyle().setFgColor(0x000000);



        // Create a button to trigger the search
        Button searchButton = new Button("Search");
        searchButton.addActionListener(e -> {
            // Get the values of x and y from the text fields
            String x = xField.getText();
            String y = yField.getText();

          
searchResultsContainer.removeAll();

    // Parse the JSON string
    String jsonString = "[{\"document\":\"data:application\\/x-empty;base64,\",\"id\":10,\"num\":\"11111222\",\"role\":\"Mechanicien\",\"location\":\"Manouba\",\"idUser\":{\"id\":1,\"nom\":\"sahbi\",\"prenom\":\"kh\",\"role\":\"reee\",\"__initializer__\":null,\"__cloner__\":null,\"__isInitialized__\":true}},{\"document\":\"data:application\\/x-empty;base64,\",\"id\":11,\"num\":\"22222222\",\"role\":\"Mechanicien\",\"location\":\"Manouba\",\"idUser\":{\"id\":2,\"nom\":\"Mohamed\",\"prenom\":\"Ali\",\"role\":\"Ouvrier\",\"__initializer__\":null,\"__cloner__\":null,\"__isInitialized__\":true}},{\"document\":\"data:application\\/x-empty;base64,\",\"id\":12,\"num\":\"22222223\",\"role\":\"Mechanicien\",\"location\":\"Manouba\",\"idUser\":{\"id\":2,\"nom\":\"Mohamed\",\"prenom\":\"Ali\",\"role\":\"Ouvrier\",\"__initializer__\":null,\"__cloner__\":null,\"__isInitialized__\":true}},{\"document\":\"data:application\\/x-empty;base64,\",\"id\":13,\"num\":\"12344444\",\"role\":\"Mechanicien\",\"location\":\"Tataouine\",\"idUser\":{\"id\":1,\"nom\":\"sahbi\",\"prenom\":\"kh\",\"role\":\"reee\",\"__initializer__\":null,\"__cloner__\":null,\"__isInitialized__\":true}},{\"document\":\"data:application\\/x-empty;base64,\",\"id\":14,\"num\":\"99999999\",\"role\":\"Mechanicien\",\"location\":\"Le Kef\",\"idUser\":{\"id\":1,\"nom\":\"sahbi\",\"prenom\":\"kh\",\"role\":\"reee\",\"__initializer__\":null,\"__cloner__\":null,\"__isInitialized__\":true}}]";
    JSONArray jsonArray = new JSONArray(jsonString);

    // Iterate over the JSON array and filter based on location and role
    for (int i = 0; i < jsonArray.length(); i++) {
        JSONObject jsonApplication = jsonArray.getJSONObject(i);
        String location = jsonApplication.getString("location");
        String role = jsonApplication.getString("role");

        if (location.equals(x) && role.equals(y)) {
            // Extract the id from idUser
            JSONObject idUser = jsonApplication.getJSONObject("idUser");
            int userId = idUser.getInt("id");

            // Create a label to display the id of the user
            Label idLabel = new Label("ID: " + userId);

            // Add the label to the search results container
            searchResultsContainer.add(idLabel);
        }
    }

    // Refresh the form to reflect the updated search results
    form.revalidate();
           
        });

        // Create a container to hold the search results
        searchResultsContainer = new Container(new BoxLayout(BoxLayout.Y_AXIS));
searchResultsContainer.getUnselectedStyle().setBgColor(0x000000);
searchResultsContainer.getUnselectedStyle().setBgTransparency(255);

        // Add the text fields, search button, and search results container to the form
        form.add(xField).add(yField).add(searchButton).add(searchResultsContainer);
    }
    
    public void show() {
        form.show();
    }*/
}
