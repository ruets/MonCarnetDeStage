package fr.iut2.saeprojet.ui.synthese;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.LinearLayout;
import android.widget.TextView;

import androidx.annotation.NonNull;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentTransaction;
import androidx.lifecycle.ViewModelProvider;

import fr.iut2.saeprojet.MainActivity;
import fr.iut2.saeprojet.NewOffresActivity;
import fr.iut2.saeprojet.R;
import fr.iut2.saeprojet.api.APIClient;
import fr.iut2.saeprojet.api.ResultatAppel;
import fr.iut2.saeprojet.databinding.FragmentSyntheseBinding;
import fr.iut2.saeprojet.entity.Candidature;
import fr.iut2.saeprojet.entity.CandidaturesResponse;
import fr.iut2.saeprojet.entity.CompteEtudiant;
import fr.iut2.saeprojet.entity.Entreprise;
import fr.iut2.saeprojet.entity.Offre;
import fr.iut2.saeprojet.entity.OffresResponse;
import fr.iut2.saeprojet.ui.candidatures.CandidaturesFragment;
import fr.iut2.saeprojet.ui.offres.OffresFragment;

public class SyntheseFragment extends Fragment {

    private FragmentSyntheseBinding binding;

    private LinearLayout newOffres, candidatures, offres;
    private TextView candidaturesMain, candidaturesPending, candidaturesRefused, candidaturesAccepted;
    private TextView offresMain, offresFavorites, offresChecked;

    public View onCreateView(@NonNull LayoutInflater inflater,
                             ViewGroup container, Bundle savedInstanceState) {

        binding = FragmentSyntheseBinding.inflate(inflater, container, false);
        View root = binding.getRoot();

        init();

        return root;
    }

    @Override
    public void onDestroyView() {
        super.onDestroyView();
        binding = null;
    }

    private void init() {
        newOffres = binding.syntheseNew;
        candidatures = binding.syntheseCandidatures;
        offres = binding.syntheseOffres;

        candidaturesMain = binding.syntheseCandidaturesMain;
        candidaturesPending = binding.syntheseCandidaturesPending;
        candidaturesRefused = binding.syntheseCandidaturesRefused;
        candidaturesAccepted = binding.syntheseCandidaturesAccepted;

        offresMain = binding.syntheseOffresMain;
        offresFavorites = binding.syntheseOffresFavorites;
        offresChecked = binding.syntheseOffresChecked;

        MainActivity mainActivity = (MainActivity) getActivity();

        newOffres.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent intent = new Intent(mainActivity, NewOffresActivity.class);
                startActivity(intent);
            }
        });

        candidatures.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                //TODO
                /*// Créer une instance du fragment à afficher
                OffresFragment fragment = new OffresFragment();

                // Obtenir le gestionnaire de fragments
                FragmentManager fragmentManager = mainActivity.getSupportFragmentManager();

                // Remplacer le fragment actuel par le nouveau fragment
                fragmentManager.beginTransaction()
                        .replace(R.id.nav_host_fragment_activity_main, fragment)
                        .commit();*/
            }
        });

        offres.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                //TODO
                /*// Créer une instance du fragment à afficher
                CandidaturesFragment fragment = new CandidaturesFragment();

                // Obtenir le gestionnaire de fragments
                FragmentManager fragmentManager = mainActivity.getSupportFragmentManager();

                // Remplacer le fragment actuel par le nouveau fragment
                fragmentManager.beginTransaction()
                        .replace(R.id.nav_host_fragment_activity_main, fragment)
                        .commit();*/
            }
        });

        APIClient.getCandidatures(mainActivity, new ResultatAppel<CandidaturesResponse>() {
            @Override
            public void traiterResultat(CandidaturesResponse candidatures) {
                int candidaturesCount = 0, candidaturesPendingCount = 0, candidaturesRefusedCount = 0, candidaturesAcceptedCount = 0;

                for (Candidature candidature : candidatures.candidatures) {
                    if (candidature.compteEtudiant.equals(mainActivity.getCompte_Id())) {
                        candidaturesCount++;

                        switch (candidature.etatCandidature) {
                            case "/api/etat_candidatures/1":
                            case "/api/etat_candidatures/2":
                            case "/api/etat_candidatures/4":
                            case "/api/etat_candidatures/5":
                                candidaturesPendingCount++;
                                break;
                            case "/api/etat_candidatures/3":
                                candidaturesRefusedCount++;
                                break;
                            case "/api/etat_candidatures/6":
                                candidaturesAcceptedCount++;
                                break;
                        }
                    }
                }
                candidaturesMain.setText(String.valueOf(candidaturesCount) + " " + candidaturesMain.getText().toString());
                candidaturesPending.setText(String.valueOf(candidaturesPendingCount) + " " + candidaturesPending.getText().toString());
                candidaturesRefused.setText(String.valueOf(candidaturesRefusedCount) + " " + candidaturesRefused.getText().toString());
                candidaturesAccepted.setText(String.valueOf(candidaturesAcceptedCount) + " " + candidaturesAccepted.getText().toString());
            }

            @Override
            public void traiterErreur() {
                candidaturesMain.setText("Erreur");
            }
        });

        APIClient.getOffres(mainActivity, new ResultatAppel<OffresResponse>() {
            @Override
            public void traiterResultat(OffresResponse offres) {
                offresMain.setText(String.valueOf(offres.offres.size()) + " " + offresMain.getText().toString());
            }

            @Override
            public void traiterErreur() {
                offresMain.setText("Erreur");
            }
        });

        APIClient.getCompteEtudiant(mainActivity, mainActivity.getCompteId(), new ResultatAppel<CompteEtudiant>() {
            @Override
            public void traiterResultat(CompteEtudiant compteEtudiant) {
                offresFavorites.setText(String.valueOf(compteEtudiant.offreRetenues.size()) + " " + offresFavorites.getText().toString());
                offresChecked.setText(String.valueOf(compteEtudiant.offreConsultees.size()) + " " + offresChecked.getText().toString());
            }

            @Override
            public void traiterErreur() {
                offresFavorites.setText("Erreur");
                offresChecked.setText("Erreur");
            }
        });
    }

}