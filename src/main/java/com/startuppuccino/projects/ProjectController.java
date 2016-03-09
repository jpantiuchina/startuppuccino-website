package com.startuppuccino.projects;

import com.startuppuccino.accounts.Account;
import com.startuppuccino.accounts.AccountService;
import java.security.Principal;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.ui.Model;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;

import static com.sun.org.apache.xalan.internal.xsltc.compiler.util.Type.Int;



@Controller
@RequestMapping("/projects")
public class ProjectController
{
    @Autowired
    private ProjectRepository projectRepository;

    @Autowired
    private ProjectAccountRepository projectAccountRepository;

    @Autowired
    private AccountService accountService;


    @RequestMapping(value = "", method = RequestMethod.GET)
    public String index(Model model)
    {
        model.addAttribute(projectRepository.findAll());
        return "projects/index";
    }


    @RequestMapping(value = "/{id}", method = RequestMethod.GET)
    public String project(@PathVariable("id") int id, Model model)
    {
        model.addAttribute(projectRepository.findOne(id));
        return "projects/project";
    }


    @RequestMapping(value = "/{id}/join", method = RequestMethod.POST)
    public String join(@PathVariable("id") int id, Principal principal, Model model)
    {
        Account account = accountService.getCurrentAccount(principal);
        Project project = projectRepository.getOne(id);

        ProjectAccount projectAccount = new ProjectAccount();
        projectAccount.setAccount(account);
        projectAccount.setProject(project);

        projectAccountRepository.saveAndFlush(projectAccount);

        model.addAttribute(projectRepository.findOne(id));
        return "redirect:/projects/" + id;
    }




}
