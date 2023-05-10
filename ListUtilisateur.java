/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package com.mycompany.gui;



import com.codename1.components.InfiniteProgress;
import com.codename1.l10n.SimpleDateFormat;
import com.codename1.ui.Button;
import com.codename1.ui.Component;
import com.codename1.ui.Container;
import com.codename1.ui.Dialog;
import com.codename1.ui.Display;
import com.codename1.ui.FontImage;
import com.codename1.ui.Form;
import com.codename1.ui.Label;
import com.codename1.ui.TextArea;
import com.codename1.ui.TextField;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.plaf.Border;
import com.codename1.ui.plaf.Style;
import com.codename1.ui.plaf.UIManager;
import com.mycomany.entities.Utilisateur;
import com.mycompany.services.ServiceUtilisateur;
import java.util.ArrayList;

import com.codename1.components.InfiniteProgress;
import com.codename1.components.ScaleImageLabel;
import com.codename1.components.SpanLabel;
import com.codename1.l10n.SimpleDateFormat;
import com.codename1.ui.Button;
import com.codename1.ui.ButtonGroup;
import com.codename1.ui.Command;
import com.codename1.ui.Component;
import com.codename1.ui.Container;
import com.codename1.ui.Dialog;
import com.codename1.ui.Display;
import com.codename1.ui.EncodedImage;
import com.codename1.ui.FontImage;
import com.codename1.ui.Form;
import com.codename1.ui.Graphics;
import com.codename1.ui.Image;
import com.codename1.ui.Label;
import com.codename1.ui.RadioButton;
import com.codename1.ui.Tabs;
import com.codename1.ui.TextArea;
import com.codename1.ui.TextField;
import com.codename1.ui.Toolbar;
import com.codename1.ui.URLImage;
import com.codename1.ui.events.ActionEvent;
import com.codename1.ui.layouts.BorderLayout;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.layouts.FlowLayout;
import com.codename1.ui.layouts.GridLayout;
import com.codename1.ui.layouts.LayeredLayout;
import com.codename1.ui.plaf.Border;
import com.codename1.ui.plaf.Style;
import com.codename1.ui.plaf.UIManager;
import com.codename1.ui.util.Resources;
import java.util.ArrayList;


/**
 *
 * @author Mariem
 */

    
    
public class ListUtilisateur extends BaseForm{
    
     //1  Form current;
    
       //    BaseForm current;
  //  BaseForm current = new BaseForm();
  

   
    
    
    
    
}
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    

    
   /*     

    current = this; // Ajoutez cette ligne pour initialiser la variable current

   


       
    
        setTitle("Liste des Produits");
        setLayout(BoxLayout.y());
        setUIID("ListProduitForm");

        ArrayList<Utilisateur> utilisateurs = ServiceUtilisateur.getInstance().getAllLUtilisateur();

        Container container = null;
        Button trie = new Button("Actualiser");
        trie.getStyle().setFgColor(0xff7fff);
        trie.setUIID("buttonWhiteCenter");
        Style modifierStyle = new Style(trie.getUnselectedStyle());
        modifierStyle.setFgColor(0xff7fff);

        trie.addActionListener(e -> new ListUtilisateur(previous).show());
        add(trie);
    for (Utilisateur u : utilisateurs) {
    container = new Container(new BoxLayout(BoxLayout.Y_AXIS)); // define container here

    Label idLabel = new Label("ID : " + u.getId());
    idLabel.getStyle().setFgColor(0x555555);
    idLabel.getStyle().setPadding(0, 0, 5, 0);
    Label cinLabel = new Label("cin : " + u.getCin());
    cinLabel.getStyle().setFgColor(0x555555);
    cinLabel.getStyle().setPadding(0, 0, 5, 0);
    Label nomLabel = new Label("Nom : " + u.getNom());
    nomLabel.getStyle().setFgColor(0x555555);
    nomLabel.getStyle().setPadding(0, 0, 5, 0);
    Label prenomLabel = new Label("Prenom : " + u.getPrenom());
    prenomLabel.getStyle().setFgColor(0x555555);
    prenomLabel.getStyle().setPadding(0, 0, 5, 0);
    Label passwordLabel = new Label("Password : " + u.getPassword());
    passwordLabel.getStyle().setFgColor(0x555555);
    passwordLabel.getStyle().setPadding(0, 0, 5, 0);
    Label mailLabel = new Label("Mail : " + u.getMail());
    mailLabel.getStyle().setFgColor(0x555555);
    mailLabel.getStyle().setPadding(0, 0, 5, 0);
    Label roleLabel = new Label("role : " + u.getRole());
    roleLabel.getStyle().setFgColor(0x555555);
    roleLabel.getStyle().setPadding(0, 0, 5, 0);
    Label telLabel = new Label("tel : " + u.getTel());
    telLabel.getStyle().setFgColor(0x555555);
    telLabel.getStyle().setPadding(0, 0, 5, 0);
    
    Label labelSupprimer = new Label(" ");
    labelSupprimer.setUIID("NewsTopLine");
    labelSupprimer.getStyle().setFgColor(0xf21f1f);

    FontImage suprrimerImage = FontImage.createMaterial(FontImage.MATERIAL_DELETE, labelSupprimer.getStyle());
    labelSupprimer.setIcon(suprrimerImage);
    labelSupprimer.setTextPosition(Component.RIGHT);

    

    Button buttonSupprimer = new Button("Supprimer");

    //supprimer button
    buttonSupprimer.setUIID("NewsTopLine");
    buttonSupprimer.setIcon(suprrimerImage);
    buttonSupprimer.setTextPosition(Component.RIGHT);

    //click delete icon
    final Container finalContainer = container;
    buttonSupprimer.addPointerPressedListener(e -> {
        Dialog dig = new Dialog("Suppression");
        if (dig.show("Suppression", "Vous voulez supprimer ce Produit ?", "Annuler", "Oui")) {
            dig.dispose();
        } else {
            dig.dispose();
        }
        // supprimer le produit en utilisant le service Produit
        if (ServiceUtilisateur.getInstance().deleteUser(u.getId())) {
            // supprimer le conteneur parent du bouton supprimer
            e.getComponent().getParent().remove();
            refreshTheme();
        }
    });

            Utilisateur r = u;
            Label rModifier = new Label(" ");
            rModifier.setUIID("NewsTopLine");
            FontImage modifierImage = FontImage.createMaterial(FontImage.MATERIAL_MODE_EDIT, rModifier.getStyle());
            rModifier.setIcon(modifierImage);
            rModifier.setTextPosition(LEFT);

            rModifier.addPointerPressedListener(m -> {
                // System.out.println("hello update");
                new EditForm(current,u).show();
            });
        
        

      //final Container  container = new Container(new BoxLayout(BoxLayout.Y_AXIS)); // initialize container here
        container.getStyle().setPadding(10, 10, 10, 10);
        container.getStyle().setBorder(Border.createLineBorder(2));
        container.getStyle().setBgTransparency(255);
        container.getStyle().setBgColor(0xffffff);
        container.add(idLabel);
        container.add(cinLabel);
        container.add(nomLabel);
        container.add(prenomLabel);
        container.add(passwordLabel);
        container.add(mailLabel);
        container.add(roleLabel);
        container.add(telLabel);
       
        container.add(buttonSupprimer);
         container.add(rModifier);  

        add(container);
    }
          
        getToolbar().addMaterialCommandToLeftBar("", FontImage.MATERIAL_ARROW_BACK, e -> previous.showBack());
         getToolbar().addCommandToSideMenu("Liste des utilisateurs", null, ev-> new BaseForm().show());

       // getToolbar().addCommandToSideMenu("Home", null, ev-> new SignUpForm(current).show());
       
       getToolbar().addCommandToSideMenu("Home", null, ev -> new SignUpForm(current.getResources()).show());


      
}*/
    

    

